<?php

namespace App\Http\Controllers;

use App\Jobs\LimparCacheDoces;
use Illuminate\Http\Request;
use App\Models\DoceModel;
use App\Models\CompraModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class TestController extends Controller
{
    private const TTL_LISTA   = 30;
    private const TTL_DETALHE = 60;

    private function keyTodos(): string
    {
        return 'doces.todos';
    }

    private function keyDoce(int $id): string
    {
        return "doces.{$id}";
    }

    private function keyDoceUsuario(int $id, int $userId): string
    {
        return "doces.{$id}.user.{$userId}";
    }

    public function salva_doce(Request $request)
    {
        $request->validate([
            'Nome'         => 'required',
            'Sabor'        => 'required',
            'Ingredientes' => 'required',
            'Preco'        => 'required|numeric|min:0',
            'Alergicos'    => 'required',
            'Quantidade'   => 'required|integer|min:0',
            'Descricao'    => 'required',
            'imagem'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        try {
            $usuario = $request->attributes->get('usuario');

            $imagemPath = null;
            if ($request->hasFile('imagem')) {
                $imagemPath = $request->file('imagem')->store('imagens_doces', 'public');
            }

            DoceModel::create([
                'Nome'         => $request->Nome,
                'Sabor'        => $request->Sabor,
                'Ingredientes' => $request->Ingredientes,
                'Preco'        => $request->Preco,
                'Alergicos'    => $request->Alergicos,
                'Quantidade'   => $request->Quantidade,
                'Descricao'    => $request->Descricao,
                'imagem'       => $imagemPath,
                'user_id'      => $usuario->id,
            ]);

            LimparCacheDoces::dispatch(null, $usuario->id);

            return redirect('/doces')->with('sucesso', 'Doce cadastrado com sucesso!');

        } catch (\Throwable $th) {
            return redirect()->back()->with('erro', 'Erro ao cadastrar doce: ' . $th->getMessage());
        }
    }


    public function exibe_doce(Request $request, $id)
    {
        $usuario = $request->attributes->get('usuario');

        $doce = Cache::remember($this->keyDoceUsuario($id, $usuario->id), now()->addMinutes(self::TTL_DETALHE), function () use ($id, $usuario) {
            return DoceModel::where('id', $id)
                ->where('user_id', $usuario->id)
                ->first();
        });

        if (!$doce) {
            return response()->json(['erro' => 's', 'mensagem' => 'Doce não encontrado'], 404);
        }

        return response()->json(['erro' => 'n', 'doces' => $doce], 200);
    }

    public function editar_doce(Request $request, $id)
    {
        $usuario = $request->attributes->get('usuario');

        $doce = Cache::remember($this->keyDoceUsuario($id, $usuario->id), now()->addMinutes(self::TTL_DETALHE), function () use ($id, $usuario) {
            return DoceModel::where('id', $id)
                ->where('user_id', $usuario->id)
                ->first();
        });

        if (!$doce) {
            return redirect('/doces')->with('erro', 'Doce não encontrado ou sem permissão');
        }

        return view('alteraDoce', compact('doce'));
    }

    public function atualiza_doce(Request $request, $id)
    {
        $request->validate([
            'Nome'         => 'required',
            'Sabor'        => 'required',
            'Ingredientes' => 'required',
            'Preco'        => 'required|numeric|min:0',
            'Alergicos'    => 'required',
            'Quantidade'   => 'required|integer|min:0',
            'Descricao'    => 'required',
            'imagem'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        try {
            $usuario = $request->attributes->get('usuario');

            $doce = DoceModel::where('id', $id)
                ->where('user_id', $usuario->id)
                ->firstOrFail();

            $imagemPath = $doce->imagem;
            if ($request->hasFile('imagem')) {
                if (!empty($doce->imagem) && Storage::disk('public')->exists($doce->imagem)) {
                    Storage::disk('public')->delete($doce->imagem);
                }
                $imagemPath = $request->file('imagem')->store('imagens_doces', 'public');
            }

            $doce->update([
                'Nome'         => $request->Nome,
                'Sabor'        => $request->Sabor,
                'Ingredientes' => $request->Ingredientes,
                'Preco'        => $request->Preco,
                'Alergicos'    => $request->Alergicos,
                'Quantidade'   => $request->Quantidade,
                'Descricao'    => $request->Descricao,
                'imagem'       => $imagemPath,
            ]);

            LimparCacheDoces::dispatch($id, $usuario->id);

            return redirect('/doces')->with('sucesso', 'Doce atualizado com sucesso!');

        } catch (\Throwable $th) {
            return redirect()->back()->with('erro', 'Erro ao atualizar doce: ' . $th->getMessage());
        }
    }


    public function todos_doces()
    {
        // Para atualizar o catálogo o mais perto do instantâneo possível,
        // não cachear eternamente quando estamos com compra/estoque dinâmico.
        $doces = DoceModel::all();
        return response()->json(['erro' => 'n', 'doces' => $doces], 200);
    }


    public function exibe_doce_view(Request $request, $id)
    {
        // Para atualizar o estoque o mais rápido possível, não usar cache no detalhe.
        $doce = DoceModel::where('id', $id)->first();


        if (!$doce) {
            return redirect('/doces')->with('erro', 'Doce não encontrado');
        }

        return view('exibeDoce', compact('doce'));
    }

    public function mostrar_formulario_delete(Request $request, $id)
    {
        $usuario = $request->attributes->get('usuario');

        $doce = Cache::remember($this->keyDoceUsuario($id, $usuario->id), now()->addMinutes(self::TTL_DETALHE), function () use ($id, $usuario) {
            return DoceModel::where('id', $id)
                ->where('user_id', $usuario->id)
                ->first();
        });

        if (!$doce) {
            return redirect('/doces')->with('erro', 'Sem permissão');
        }

        return view('deletaDoce', compact('doce', 'id'));
    }

    public function deleta_doce(Request $request, $id)
    {
        try {
            $usuario = $request->attributes->get('usuario');

            $doce = DoceModel::where('id', $id)
                ->where('user_id', $usuario->id)
                ->firstOrFail();

            $doce->delete();

            LimparCacheDoces::dispatch($id, $usuario->id);

            return redirect('/doces')->with('sucesso', 'Doce deletado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('erro', 'Erro ao deletar doce');
        }
    }

    public function comprar_doce(Request $request, $id)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);


        $usuario = $request->attributes->get('usuario');
        $quantidade = (int) $request->input('quantidade');

        try {
            $resultado = DB::transaction(function () use ($id, $quantidade, $usuario) {
                $doce = DoceModel::where('id', $id)->lockForUpdate()->first();

                if (!$doce) {
                    return [
                        'ok' => false,
                        'status' => 404,
                        'message' => 'Doce não encontrado',
                    ];
                }

                
                if ((int) $doce->Quantidade < $quantidade) {
                    return [
                        'ok' => false,
                        'status' => 422,
                        'message' => 'Quantidade solicitada maior do que o estoque disponível',
                        'estoque_disponivel' => (int) $doce->Quantidade,
                    ];
                }

                
                $doce->Quantidade = (int) $doce->Quantidade - $quantidade;
                $doce->save();

                
                if ((int) $doce->Quantidade <= 0) {
                    $doce->delete();
                }

                LimparCacheDoces::dispatch(null, null);

                $trackingCode = strtoupper(Str::random(10));



                $total = ((int) $doce->Preco) * $quantidade;

                $compra = CompraModel::create([
                    'user_id' => $usuario->id,
                    'doce_id' => $doce->id,
                    'quantidade' => $quantidade,
                    'total' => $total,
                    'tracking_status' => 'PREPARANDO',
                    'tracking_code' => $trackingCode,
                ]);

                return [
                    'ok' => true,
                    'compra' => $compra,
                    'tracking' => [
                        'status' => $compra->tracking_status,
                        'codigo' => $compra->tracking_code,
                    ],
                ];
            });

            if (!$resultado['ok']) {
                return response()->json([
                    'erro' => 's',
                    'mensagem' => $resultado['message'],
                    'estoque_disponivel' => $resultado['estoque_disponivel'] ?? null,
                ], $resultado['status']);
            }

            return response()->json([
                'erro' => 'n',
                'mensagem' => 'Compra registrada com sucesso!',
                'tracking' => $resultado['tracking'],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'erro' => 's',
                'mensagem' => 'Erro ao processar compra: ' . $th->getMessage(),
            ], 500);
        }
    }

    public function listar_carrinho(Request $request)
    {
        $usuario = $request->attributes->get('usuario');

        $compras = CompraModel::where('user_id', $usuario->id)
            ->orderByDesc('id')
            ->get()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'doce_id' => $c->doce_id,
                    'quantidade' => $c->quantidade,
                    'doce_nome' => optional(DoceModel::where('id', $c->doce_id)->first())->Nome,

                    'status' => $c->tracking_status,
                    'tracking' => [
                        'codigo' => $c->tracking_code,
                    ],
                ];
            });

        return response()->json([
            'erro' => 'n',
            'compras' => $compras,
        ], 200);
    }

    public function avancar_compra(Request $request, int $id)
    {
        $usuario = $request->attributes->get('usuario');

        $compra = CompraModel::where('id', $id)->where('user_id', $usuario->id)->first();
        if (!$compra) {
            return response()->json(['erro' => 's', 'mensagem' => 'Compra não encontrada'], 404);
        }

        $etapas = ['PREPARANDO', 'SAIU_PARA_ENTREGA', 'CHEGOU', 'FINALIZADA'];
        $idx = array_search($compra->tracking_status, $etapas, true);
        $novoIdx = $idx === false ? 0 : min($idx + 1, count($etapas) - 1);

        $compra->tracking_status = $etapas[$novoIdx];
        $compra->save();

        
        // Ao finalizar, mantém tudo consistente com o estoque já reduzido na compra.
        // (Demo: só organiza a "visão"; não mexe mais no estoque aqui.)

        return response()->json([
            'erro' => 'n',
            'mensagem' => 'Etapa avançada (demo).',
            'status' => $compra->tracking_status,
        ], 200);

    }
}

