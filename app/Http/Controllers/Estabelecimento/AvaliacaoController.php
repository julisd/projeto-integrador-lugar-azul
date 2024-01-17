<?php

namespace App\Http\Controllers\Estabelecimento;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estabelecimento;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Endereco;
use App\Models\AvaliacaoComentario;

class AvaliacaoController extends Controller
{
    public function criarAvaliacao(Request $request)
    {
        // Validando os dados recebidos no request
        $validatedData = $request->validate([
            'avaliacao' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
            'estabelecimento_id' => 'required|exists:estabelecimentos,id'
        ]);

        // Obtendo o ID do usuário pessoa_usuaria autenticado
        $usuarioId = auth('pessoa_usuaria')->id();

        // Verificando se o usuário já possui um comentário para o estabelecimento
        $avaliacaoExistente = AvaliacaoComentario::where('usuario_id', $usuarioId)
            ->where('estabelecimento_id', $validatedData['estabelecimento_id'])
            ->first();

        if ($avaliacaoExistente) {
            // Atualizar a avaliação existente
            $avaliacaoExistente->update([
                'avaliacao' => $validatedData['avaliacao'],
                'comentario' => $validatedData['comentario'],
            ]);

            // Redirecionamento após atualizar a avaliação
            return redirect()->back()->with('success', 'Avaliação atualizada com sucesso!');
        } else {
            // Criar uma nova avaliação
            $avaliacao = new AvaliacaoComentario();
            $avaliacao->usuario_id = $usuarioId;
            $avaliacao->estabelecimento_id = $validatedData['estabelecimento_id'];
            $avaliacao->avaliacao = $validatedData['avaliacao'];
            $avaliacao->comentario = $validatedData['comentario'];
            $avaliacao->save();

            // Redirecionamento após criar a avaliação
            return redirect()->back()->with('success', 'Avaliação criada com sucesso!');
        }
    }



    public function buscarComentarios($idDoEstabelecimento)
    
    {
        // Buscar os comentários pelo ID do estabelecimento
        $comentarios = AvaliacaoComentario::with('usuario')
        ->where('estabelecimento_id', $idDoEstabelecimento)
        ->get();

        // Retornar os comentários (possivelmente em formato JSON, dependendo da necessidade)
        return response()->json(['comentarios' => $comentarios]);
    }

    public function show($id)
{
    // Buscando o estabelecimento e o endereço relacionados ao mesmo ID
    $estabelecimento = Estabelecimento::find($id);
    $endereco = Endereco::find($id);
    // Buscando os comentários com o relacionamento do usuário carregado
    $comentarios = AvaliacaoComentario::with('usuario')
        ->where('estabelecimento_id', $id)
        ->get();

        dd($comentarios);

    $comentariosFormatados = [];

    foreach ($comentarios as $comentario) {
        $usuarioNome = $comentario->usuario ? $comentario->usuario->name : 'Anônimo';

        $comentariosFormatados[] = [
            'usuario_nome' => $usuarioNome,
            'avaliacao' => $comentario->avaliacao,
            'comentario' => $comentario->comentario,
            'created_at' => \Carbon\Carbon::parse($comentario->created_at)->format('d/m/Y'),
        ];
    }

    return view('estabelecimento.saibaMais', [
        'estabelecimento' => $estabelecimento,
        'nomeDoEstabelecimento' => $estabelecimento->name,
        'descricao' => $estabelecimento->description,
        'telefone' => $estabelecimento->telephone,
        'email' => $estabelecimento->email,
        'logradouro' => $endereco->logradouro,
        'numero' => $endereco->numero,
        'complemento' => $endereco->complemento,
        'bairro' => $endereco->bairro,
        'cidade' => $endereco->city,
        'comentarios' => $comentariosFormatados,
    ]);
}

    
}
