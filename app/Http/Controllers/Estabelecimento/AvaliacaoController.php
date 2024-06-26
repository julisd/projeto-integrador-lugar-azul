<?php

namespace App\Http\Controllers\Estabelecimento;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estabelecimento;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;
use App\Models\Endereco;
use App\Models\AvaliacaoComentario;
use App\Models\AvaliacaoComentarioResposta;

class AvaliacaoController extends Controller
{

    public function mostrarComentarios($id)
    {
        // Buscando o estabelecimento e o endereço relacionados ao mesmo ID
        $estabelecimento = Estabelecimento::find($id);
    
        // Buscando os comentários com o relacionamento do usuário carregado
        $comentarios = AvaliacaoComentario::with(['usuario', 'respostas'])
            ->where('estabelecimento_id', $id)
            ->get();
    
        $comentariosFormatados = [];
        $respostasFormatadas = []; // Inicializa a variável fora do loop
    
        foreach ($comentarios as $comentario) {
            $usuarioNome = $comentario->usuario ? $comentario->usuario->name : 'Anônimo';
    
            $respostas = $comentario->respostas()->get(); // Recuperando as respostas
    
            // Formatando as respostas
            $respostasFormatadas = [];
            foreach ($respostas as $resposta) {
                $respostasFormatadas[] = [
                    'texto' => $resposta->resposta,
                    'created_at' => $resposta->created_at->format('d/m/Y'),
                ];
            }
    
            $comentariosFormatados[] = [
                'id' => $comentario->id,
                'usuario_nome' => $usuarioNome,
                'avaliacao' => $comentario->avaliacao,
                'comentario' => $comentario->comentario,
                'created_at' => $comentario->created_at->format('d/m/Y'),
                'respostas' => $respostasFormatadas, // Associando as respostas ao comentário
            ];
        }
    
        return view('estabelecimento.comentarios', [
            'nomeDoEstabelecimento' => $estabelecimento->name,
            'estabelecimento' => $estabelecimento,
            'nomeDoEstabelecimento' => $estabelecimento->name,
            'descricao' => $estabelecimento->description,
            'telefone' => $estabelecimento->telephone,
            'email' => $estabelecimento->email,
            'comentarios' => $comentariosFormatados,
            'respostas' => $respostasFormatadas, 
        ]);
    }
    

    public function responderComentario(Request $request)
{
    try {
        Log::info('Resposta salva: bateu');

        $validatedData = $request->validate([
            'avaliacao_comentario_id' => 'required|exists:avaliacoes_comentarios,id',
            'resposta' => 'required|string',
        ]);

        Log::info('Validação passou');

        // Verificar se já existe uma resposta para esse comentário
        $respostaExistente = AvaliacaoComentarioResposta::where('avaliacao_comentario_id', $validatedData['avaliacao_comentario_id'])->first();

        if ($respostaExistente) {
            // Se já existe uma resposta, atualize-a
            $respostaExistente->update(['resposta' => $validatedData['resposta']]);
            Log::info('Resposta atualizada: ' . $validatedData['resposta']);
        } else {
            // Se não existe uma resposta, crie uma nova
            $resposta = new AvaliacaoComentarioResposta();
            $resposta->avaliacao_comentario_id = $validatedData['avaliacao_comentario_id'];
            $resposta->resposta = $validatedData['resposta'];
            $resposta->save();
            Log::info('Resposta salva: ' . $validatedData['resposta']);
        }

        // Retornar uma resposta JSON indicando sucesso
        return response()->json(['success' => 'Resposta enviada com sucesso!']);
    } catch (\Exception $e) {
        // Log do erro
        Log::error('Erro ao responder comentário: ' . $e->getMessage());

        // Retornar uma resposta JSON indicando erro
        return response()->json(['error' => 'Ocorreu um erro ao responder ao comentário. Por favor, tente novamente.'], 500);
    }
}


public function criarAvaliacao(Request $request)
{
    Log::info('Iniciando o processo de criação de avaliação.');

    Log::info('Dados recebidos no request: ' . json_encode($request->all()));

    $validatedData = $request->validate([
        'avaliacao' => 'required|integer|min:1|max:5',
        'comentario' => 'nullable|string',
        'estabelecimento_id' => 'required|exists:estabelecimentos,id'
    ]);

    // Obtendo o ID do estabelecimento
    $estabelecimentoId = $request->input('estabelecimento_id');

    // Obtendo o ID do usuário pessoa_usuaria autenticado
    $usuarioId = auth('pessoa_usuaria')->id();

    // Log do início do processo de criação de avaliação
    Log::info('Iniciando o processo de criação de avaliação.');

    // Criar uma nova avaliação
    $avaliacao = new AvaliacaoComentario();
    $avaliacao->usuario_id = $usuarioId;
    $avaliacao->estabelecimento_id = $estabelecimentoId;
    $avaliacao->avaliacao = $validatedData['avaliacao'];
    $avaliacao->comentario = $validatedData['comentario'];
    $avaliacao->save();

    // Log da conclusão do processo de criação de avaliação
    Log::info('Avaliação criada com sucesso!');

    // Redirecionamento após criar a avaliação
    return redirect()->back()->with('success', 'Avaliação criada com sucesso!');
}





    public function buscarComentarios($idDoEstabelecimento)

    {
        // Buscar os comentários pelo ID do estabelecimento
        $comentarios = AvaliacaoComentario::with(['usuario', 'respostas'])
                ->where('estabelecimento_id', $idDoEstabelecimento)
                ->get();

                $comentariosFormatados = [];
    
            foreach ($comentarios as $comentario) {
                $usuarioNome = $comentario->usuario ? $comentario->usuario->name : 'Anônimo';
    
                $respostas = $comentario->respostas()->get(); // Recuperando as respostas
    
                // Formatando as respostas
                $respostasFormatadas = [];
                foreach ($respostas as $resposta) {
                    $respostasFormatadas[] = [
                        'texto' => $resposta->resposta,
                        'created_at' => $resposta->created_at->format('d/m/Y'),
                    ];
                }
    
                $comentariosFormatados[] = [
                    'id' => $comentario->id,
                    'usuario_nome' => $usuarioNome,
                    'avaliacao' => $comentario->avaliacao,
                    'comentario' => $comentario->comentario,
                    'created_at' => $comentario->created_at->format('d/m/Y'),
                    'respostas' => $respostasFormatadas, // Associando as respostas ao comentário
                ];
            }
    
        // Retornar os comentários (possivelmente em formato JSON, dependendo da necessidade)
        return response()->json(['comentarios' => $comentariosFormatados]);
    }

    public function show($id)
    {

            // Buscando o estabelecimento e o endereço relacionados ao mesmo ID
            $estabelecimento = Estabelecimento::find($id);
    
            // Buscando os comentários com o relacionamento do usuário carregado
            $comentarios = AvaliacaoComentario::with(['usuario', 'respostas'])
                ->where('estabelecimento_id', $id)
                ->get();
    
            $comentariosFormatados = [];
    
            foreach ($comentarios as $comentario) {
                $usuarioNome = $comentario->usuario ? $comentario->usuario->name : 'Anônimo';
    
                $respostas = $comentario->respostas()->get(); // Recuperando as respostas
    
                // Formatando as respostas
                $respostasFormatadas = [];
                foreach ($respostas as $resposta) {
                    $respostasFormatadas[] = [
                        'texto' => $resposta->resposta,
                        'created_at' => $resposta->created_at->format('d/m/Y'),
                    ];
                }
    
                $comentariosFormatados[] = [
                    'id' => $comentario->id,
                    'usuario_nome' => $usuarioNome,
                    'avaliacao' => $comentario->avaliacao,
                    'comentario' => $comentario->comentario,
                    'created_at' => $comentario->created_at->format('d/m/Y'),
                    'respostas' => $respostasFormatadas, // Associando as respostas ao comentário
                ];
            }
    
            return view('estabelecimento.saibaMais', [
                'nomeDoEstabelecimento' => $estabelecimento->name,
                'estabelecimento' => $estabelecimento,
                'nomeDoEstabelecimento' => $estabelecimento->name,
                'descricao' => $estabelecimento->description,
                'telefone' => $estabelecimento->telephone,
                'email' => $estabelecimento->email,
                'comentarios' => $comentariosFormatados,
                'respostas' => $respostasFormatadas,
            ]);
        
    
    }
}
