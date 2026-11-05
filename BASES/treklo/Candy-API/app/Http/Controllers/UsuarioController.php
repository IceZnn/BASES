<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TokenUser;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Carbon\Carbon;
use App\Jobs\EnviarEmail;
use App\Jobs\AutenticaJob;
use App\Jobs\EnviarResetSenhaJob;
use App\Models\CodigoEmail;
use App\Models\ResetSenha;
use App\Mail\ResetSenhaMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    public function cadastra_usuario(Request $request){
        $request->validate([
            "nome"     => 'required',
            "email"    => 'required|email|unique:usuario,email',
            "telefone" => 'required',
            "empresa"  => 'required',
            "senha"    => 'required|min:6',
        ]);

        try{
            $usuario           = new Usuario();
            $usuario->nome     = $request->nome;
            $usuario->email    = $request->email;
            $usuario->telefone = $request->telefone;
            $usuario->empresa  = $request->empresa;
            $usuario->senha    = md5($request->senha);
            $usuario->save();

            return response()->json([
                'erro' => 'n',
                'data' => 'Usuário cadastrado com sucesso.',
                'usuario' => $usuario
            ], 201);

        }catch(\Throwable $th){
            return response()->json([
                'erro' => 's',
                'data' => 'Erro ao cadastrar usuário: ' . $th->getMessage()
            ], 500);
        }
    }

    public function login(Request $request){
        $usuario = Usuario::where('email', $request->email)->first();

        if(!$usuario || $usuario->senha !== md5($request->senha)){
            return response()->json([
                'erro' => 's',
                'data' => 'E-mail ou senha incorretos.'
            ], 401);
        }

        if ($request->input('ativar_dupla_autentica')) {
            $usuario->dupla_autentica = '1';
            $usuario->save();
        }

        if ($usuario->dupla_autentica == '1') {
            AutenticaJob::dispatch($usuario);

            return response()->json([
                'erro' => 'p',
                'data' => 'Código de autenticação enviado para o e-mail. Digite o código para continuar.',
                'autentica_ativa' => true,
                'email' => $usuario->email,
            ], 200);
        }

        TokenUser::where('user_id', $usuario->id)->delete();

        $token = new TokenUser();
        $token->user_id    = $usuario->id;
        $data              = date('Y-m-d H:i:s');
        $tokenValue        = md5($usuario->id . $usuario->email . $data);
        $token->token      = $tokenValue;
        $token->valido_ate = Carbon::now()->addDays(7);
        $token->save();

        $response = response()->json([
            'erro'    => 'n',
            'data'    => 'Login realizado com sucesso.',
            'token'   => $tokenValue,
            'user_id' => $usuario->id,
        ], 200);

        

        return $response
            ->cookie('token',   $tokenValue,   10080, '/', null, false, false)
            ->cookie('user_id', $usuario->id,  10080, '/', null, false, false);
    }

    public function testa_email($id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        EnviarEmail::dispatch($usuario);

        $data = [
            'message' => 'Email enviado para a fila de processamento',
            'usuario' => $usuario
        ];

        return response()->json($data);
    }



    public function exibe_perfil(Request $request)
    {
        $usuario = $request->attributes->get('usuario');
        return response()->json(['erro' => 'n', 'usuario' => $usuario], 200);
    }

    public function atualiza_perfil(Request $request)
    {
        $usuario = $request->attributes->get('usuario');
        $usuario->update($request->only(['nome', 'telefone', 'empresa']));
        return response()->json(['erro' => 'n', 'data' => 'Perfil atualizado com sucesso.'], 200);
    }

    public function atualiza_senha(Request $request)
    {
        $usuario = $request->attributes->get('usuario');

        if ($usuario->senha !== md5($request->senha_atual)) {
            return response()->json(['erro' => 's', 'data' => 'Senha atual incorreta.'], 401);
        }

        $usuario->senha = md5($request->senha_nova);
        $usuario->save();

        return response()->json(['erro' => 'n', 'data' => 'Senha alterada com sucesso.'], 200);
    }

    public function atualiza_dupla_autentica(Request $request)
    {
        $usuario = $request->attributes->get('usuario');

        $request->validate([
            'ativa' => 'required|boolean'
        ]);

        $usuario->dupla_autentica = $request->ativa ? '1' : '0';
        $usuario->save();

        return response()->json([
            'erro' => 'n',
            'data' => $usuario->dupla_autentica === '1' ? 'Autenticação dupla ativada.' : 'Autenticação dupla desativada.',
            'dupla_autentica' => $usuario->dupla_autentica,
        ], 200);
    }

    public function digita_codigo(Request $request){
        return view('digita_codigo');
    }


    public function enviar_codigo(Request $request){
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required'
        ]);

        $codigo = CodigoEmail::where('email', $request->email)
            ->where('codigo', $request->codigo)
            ->where('valido_ate', '>', Carbon::now())
            ->first();

        if ($codigo) {
            $usuario = Usuario::where('email', $codigo->email)->first();
            if (!$usuario) {
                return response()->json([
                    'erro' => 's',
                    'data' => 'Usuário não encontrado para este código.'
                ], 401);
            }

            TokenUser::where('user_id', $usuario->id)->delete();
            $token = new TokenUser();
            $token->user_id = $usuario->id;
            $data = date('Y-m-d H:i:s');
            $tokenValue = md5($usuario->id . $usuario->email . $data);
            $token->token = $tokenValue;
            $token->valido_ate = Carbon::now()->addDays(7);
            $token->save();

            CodigoEmail::where('email', $request->email)->delete();

            $data = [
                'erro' => 'n',
                'data' => 'Código válido. Login realizado com sucesso.',
                'token' => $tokenValue,
                'user_id' => $usuario->id,
            ];

            return response()->json($data, 200);
        }

        return response()->json([
            'erro' => 's',
            'data' => 'Código inválido ou expirado.'
        ], 401);
    }

    public function esqueci_senha(Request $request){
        return view('esqueci_senha');
    }

    public function enviar_reset_senha(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();
        
        if (!$usuario) {
            return response()->json([
                'erro' => 's',
                'data' => 'E-mail não encontrado no sistema.'
            ], 404);
        }

        ResetSenha::where('email', $request->email)->delete();

        $codigo = rand(100000, 999999);
        $valido_ate = Carbon::now()->addMinutes(10);

        ResetSenha::create([
            'email' => $request->email,
            'codigo' => $codigo,
            'valido_ate' => $valido_ate,
        ]);

        EnviarResetSenhaJob::dispatch($request->email, $codigo);

        return response()->json([
            'erro' => 'n',
            'data' => 'Código de recuperação enviado para seu e-mail.',
            'email' => $request->email
        ], 200);
    }

    public function validar_codigo_reset(Request $request){
        $request->validate([
            'email' => 'required|email',
            'codigo' => 'required'
        ]);

        $reset = ResetSenha::where('email', $request->email)
            ->where('codigo', $request->codigo)
            ->where('valido_ate', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return response()->json([
                'erro' => 's',
                'data' => 'Código inválido ou expirado.'
            ], 401);
        }

        return response()->json([
            'erro' => 'n',
            'data' => 'Código válido. Prossiga para alterar sua senha.'
        ], 200);
    }

    public function confirmar_nova_senha(Request $request){
        $request->validate([
            'email' => 'required|email',
            'senha_nova' => 'required|min:6'
        ]);

        $usuario = Usuario::where('email', $request->email)->first();
        if (!$usuario) {
            return response()->json([
                'erro' => 's',
                'data' => 'Usuário não encontrado.'
            ], 404);
        }

        $usuario->senha = md5($request->senha_nova);
        $usuario->save();

        ResetSenha::where('email', $request->email)->delete();

        return response()->json([
            'erro' => 'n',
            'data' => 'Senha alterada com sucesso. Você será redirecionado para o início.'
        ], 200);
    }

    public function logout(Request $request)
    {
        $usuario = $request->attributes->get('usuario');
        
        if ($usuario) {
            TokenUser::where('user_id', $usuario->id)->delete();
        }

        return response()->json([
            'erro' => 'n',
            'data' => 'Deslogado com sucesso.'
        ], 200);
    }
}