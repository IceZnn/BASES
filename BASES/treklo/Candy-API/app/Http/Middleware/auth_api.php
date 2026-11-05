<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TokenUser;
use App\Models\Usuario;
use Carbon\Carbon;

class auth_api
{
    public function handle(Request $request, Closure $next): Response
    {

        if(!$request->has('token')){
            return response()->json([
                'erro' => 's',
                'msg' => 'Você nao enviou o token'
            ],401);
        }

        $hoje = Carbon::now();

        $token = TokenUser::where('token', $request->token)
            ->where('valido_ate','>=',$hoje)
            ->first();

        if(!$token){
            return response()->json([
                'erro'=> 's',
                'msg'=> 'Token inválido ou expirado',
            ],401);
        }

        $usuario = Usuario::find($token->user_id);

        if(!$usuario){
            return response()->json([
                'erro'=> 's',
                'msg'=> 'Usuário não encontrado'
            ],401);
        }

        $request->attributes->set('usuario', $usuario);
        $request->attributes->set('token', $token);

        return $next($request);
    }
}