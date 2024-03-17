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
use App\Models\HorarioEstabelecimento;
use App\Models\AvaliacaoComentario;
use App\Models\PessoaUsuaria;

class EstabelecimentoAuthController extends Controller
{

    use SendsPasswordResetEmails;

    public function obterDadosEstabelecimento(Request $request)
    {
        $id = $request->input('id');
        $estabelecimento = Estabelecimento::find($id);

        if (!$estabelecimento) {
            return response()->json(['error' => 'Estabelecimento não encontrado'], 404);
        }

        return response()->json($estabelecimento);
    }

    public function detalhes($id)
    {
        info('ID recebido:', ['id' => $id]);

        $estabelecimento = Estabelecimento::find($id); // Busca o estabelecimento no banco de dados
        $endereco = Endereco::find($id);
        $horariosEstabelecimento = HorarioEstabelecimento::where('estabelecimento_id', $id)->get();

        if (!$estabelecimento) {
            info('Estabelecimento não encontrado para o ID:', ['id' => $id]);
            abort(404); // Se não encontrar, retorna erro 404
        }

        info('Estabelecimento encontrado:', ['estabelecimento' => $estabelecimento]);

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
            'horariosEstabelecimento' => $horariosEstabelecimento, // Passa a coleção completa para a view

        ]);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $response = Password::broker('estabelecimentos')->sendResetLink(
            $request->only('email')
        );

        return redirect('/estabelecimento/login')->with('success', 'Conta criada com sucesso! Faça o login.');
    }

    public function showLoginForm()
    {
        return view('auth.estabelecimento.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('estabelecimento')->attempt($credentials)) {
            return redirect()->intended('/estabelecimento/home');
        } else {
            return redirect()->back()->withErrors(['email' => 'Email não registrado ou senha incorreta.']);
        }
    }

    public function getAutismCharacteristics()
    {

        $characteristics = [
            'Visual' => 'Visual',
            'Comunicação' => 'Comunicação',
            'Sensorial' => 'Sensorial',
            'Mental' => 'Mental',
            'Habilidades Sociais' => 'Habilidades Sociais',
            'Hiperfoco' => 'Hiperfoco',
            'Ansiedade' => 'Ansiedade',
            'Estereotipias' => 'Estereotipias',
            'Interesses Específicos' => 'Interesses Específicos',
        ];


        return $characteristics;
    }


    public function showRegistrationForm()
    {
        $characteristics = $this->getAutismCharacteristics();
        return view('auth.estabelecimento.register', compact('characteristics'));
    }

    public function showLinkRequestForm()
    {
        return view('auth.estabelecimento.passwords.email');
    }

    public function register(Request $request)
    {

        $customMessages = [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está sendo usado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não correspondem.',
            'category.required' => 'Selecione uma categoria',
            'cnpj.required' => 'O campo CNPJ é obrigatório',
            'cnpj.unique' => 'Este CNPJ já está sendo usado',
            'cnpj.regex' => 'O CNPJ informado não é válido',
            'description.required' => 'Nos ajude a te conhecer. Fala mais sobre a sua empresa?',
            'cep.required' => 'O campo CEP é obrigatório.',
            'logradouro.required' => 'O campo Logradouro é obrigatório.',
            'numero.required' => 'O campo Número é obrigatório.',
            'bairro.required' => 'O campo Bairro é obrigatório.',
            'cidade.required' => 'O campo Cidade é obrigatório.',
            'uf.required' => 'O campo UF é obrigatório.',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:estabelecimentos',
            'email' => 'required|string|email|unique:estabelecimentos',
            'password' => 'required|string|min:8|confirmed',
            'description' => 'required|string',
            'category' => 'required|string',
            'cep' => 'required|string',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
            'abertura' => 'required|date_format:H:i',
            'fechamento' => 'required|date_format:H:i|after:abertura',
            'autism_characteristics' => 'array', // Certifique-se de que é um array
            'autism_characteristics.*' => 'in:Visual,Comunicação,Sensorial,Mental,Habilidades Sociais,Hiperfoco,Ansiedade,Estereotipias,Interesses Específicos',
        ], $customMessages);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $selectedCharacteristics = $request->input('autism_characteristics');
        $estabelecimento = Estabelecimento::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => bcrypt($request->password),
            'description' => $request->description,
            'category' => $request->category,
            'status' => 'pendente',
            'autism_characteristics' => implode(',', $selectedCharacteristics),
        ]);

        // Verificação e salvamento da imagem
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName); // Salva a imagem no diretório public/uploads

            // Adicione o nome da imagem ao modelo Estabelecimento
            $estabelecimento->image = $imageName;
            $estabelecimento->save(); // Salva o modelo com o nome da imagem
        }


        // Crie o endereço associando-o ao estabelecimento
        $endereco = Endereco::create([
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'uf' => $request->uf,
            'estabelecimento_id' => $estabelecimento->id, // Associe o endereço ao estabelecimento
        ]);

        if ($estabelecimento) {
            // Iterar pelos dias selecionados e salvar os horários de funcionamento
            foreach ($request->dias_semana as $dia) {
                $estabelecimento->horarios()->create([
                    'dia_semana' => $dia,
                    'abertura' => $request->abertura,
                    'fechamento' => $request->fechamento,
                ]);
            }

            return redirect('/estabelecimento/login')->with('success', 'Conta criada com sucesso! Faça o login.');
        } else {
            return back()->withInput()->withErrors(['Falha ao criar estabelecimento']);
        }
    }

    public function horarioEstabelecimento($id)
    {
        // Supondo que você já tenha recuperado os detalhes do estabelecimento
        $estabelecimento = Estabelecimento::find($id);

        // Recuperar os horários de funcionamento do estabelecimento com ID correspondente
        $horariosEstabelecimento = HorarioEstabelecimento::where('estabelecimento_id', $id)->get();

        return view('estabelecimento.saibaMais', [
            'estabelecimento' => $estabelecimento,
            'horariosEstabelecimento' => $horariosEstabelecimento,
        ]);
    }


    public function home()
    {
        return view('estabelecimento.home');
    }

    public function editar()
    {
        $user = Auth::user();
        $characteristics = $this->getAutismCharacteristics();
        $endereco = $user->endereco; // Obtém o endereço associado ao estabelecimento

        return view('estabelecimento.editar', ['user' => $user, 'endereco' => $endereco, 'characteristics' => $characteristics]);
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:estabelecimentos,email,' . $user->id,
            'cnpj' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'cep' => 'required|string',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'uf' => 'required|string|max:2',
        ]);

        // Atualize os campos de endereço no modelo do usuário
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->cnpj = $request->cnpj;
        $user->description = $request->description;
        $user->category = $request->category;
        $user->status = 'pendente';

        $selectedCharacteristics = implode(',', $request->input('autism_characteristics'));
        $user->autism_characteristics = $selectedCharacteristics;


        // Verifique se o usuário já possui um endereço ou não
        if (!$user->endereco) {
            $user->endereco()->create([
                'cep' => $request->cep,
                'logradouro' => $request->logradouro,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'uf' => $request->uf,
            ]);
        } else {
            // Se o usuário já possui um endereço, atualize-o
            $user->endereco->cep = $request->cep;
            $user->endereco->logradouro = $request->logradouro;
            $user->endereco->numero = $request->numero;

            // Verificação e atualização do campo "complemento"
            if ($request->has('complemento')) {
                $user->endereco->complemento = $request->complemento;
            } else {
                $user->endereco->complemento = null; // Ou o valor padrão desejado
            }

            $user->endereco->bairro = $request->bairro;
            $user->endereco->cidade = $request->cidade;
            $user->endereco->uf = $request->uf;
            $user->endereco->save();
        }

        // Salvar o modelo principal
        $user->save();

        return redirect()->route('estabelecimento.home')->with('success', 'Perfil atualizado com sucesso!');
    }




    public function logout(Request $request)
    {
        Auth::guard('estabelecimento')->logout();
        return redirect('/');
    }


    public function excluirConta(Request $request)
    {
        $user = Auth::guard('estabelecimento')->user();

        Auth::guard('estabelecimento')->logout();

        $user->delete();

        return redirect('/');
    }

    public function getAllActiveEstabelecimentos(Request $request)
    {
        // Obtém os parâmetros da solicitação
        $city = $request->input('city');
        $category = $request->input('category');
        $userCharacteristicsString = $request->user('pessoa_usuaria')->autism_characteristics;

        // Converte a string em um array separando-a por vírgulas
        $userCharacteristics = explode(',', $userCharacteristicsString);

        // Remove espaços em branco adicionais antes e depois de cada característica
        $userCharacteristics = array_map('trim', $userCharacteristics);

        // Remove elementos vazios do array
        $userCharacteristics = array_filter($userCharacteristics);

        // Adicionando log para visualizar as características do usuário
        info('Características do usuário:', ['autism_characteristics' => $userCharacteristics]);

        // Inicializa a consulta
        $estabelecimentos = Estabelecimento::where('status', 'aprovado')
            ->whereHas('endereco', function ($query) use ($city) {
                $query->where('cidade', $city);
            });

        // Filtra os estabelecimentos que possuem as características do usuário
        if (!empty($userCharacteristics)) {
            $estabelecimentos->where(function ($query) use ($userCharacteristics) {
                foreach ($userCharacteristics as $characteristic) {
                    $query->orWhere('autism_characteristics', 'LIKE', "%{$characteristic}%");
                }
            });
        }

        // Executa a consulta
        $estabelecimentos = $estabelecimentos->with('endereco')->get();

        return $estabelecimentos;
    }


    public function getCategories()
    {
        $categories = Estabelecimento::distinct('category')->pluck('category');
        return response()->json($categories);
    }


    public function obterCaracteristicasUsuario(Request $request)
    {

        $userCharacteristics = $request->user('pessoa_usuaria')->autism_characteristics;

        return response()->json(['autism_characteristics' => $userCharacteristics]);
    }

    public function getEstabelecimentosPorCategoria(Request $request)
    {
        $category = $request->input('category');
        $city = $request->input('city');


        // Busca as características do usuário no banco de dados
        $userCharacteristicsString = $request->user('pessoa_usuaria')->autism_characteristics;

        // Converte a string em um array separando-a por vírgulas
        $userCharacteristics = explode(',', $userCharacteristicsString);

        // Remove espaços em branco adicionais antes e depois de cada característica
        $userCharacteristics = array_map('trim', $userCharacteristics);

        // Remove elementos vazios do array
        $userCharacteristics = array_filter($userCharacteristics);

        // Adicionando log para visualizar as características do usuário
        info('Características do usuário:', ['autism_characteristics' => $userCharacteristics]);

        $estabelecimentos = Estabelecimento::where('status', 'aprovado')
            ->where('category', $category)
            ->whereHas('endereco', function ($query) use ($city) {
                $query->where('cidade', $city);
            });

        // Filtra os estabelecimentos que possuem as características do usuário
        if (!empty($userCharacteristics)) {
            $estabelecimentos->where(function ($query) use ($userCharacteristics) {
                foreach ($userCharacteristics as $characteristic) {
                    $query->orWhere('autism_characteristics', 'LIKE', "%{$characteristic}%");
                }
            });
        }

        // Executa a consulta
        $estabelecimentos = $estabelecimentos->get();

        // Verifica se encontrou estabelecimentos
        if ($estabelecimentos->isEmpty()) {
            return response()->json([]);
        } else {
            // Transforma os dados dos estabelecimentos para o formato JSON
            $estabelecimentosData = $estabelecimentos->map(function ($estabelecimento) {
                return [
                    'name' => $estabelecimento->name,
                    'category' => $estabelecimento->category,
                    'endereco' => $estabelecimento->endereco
                ];
            });
            return response()->json($estabelecimentosData);
        }
    }


    public function contato()
    {
        return view('contato');
    }

    public function show($id)
    {
        $estabelecimento = Estabelecimento::findOrFail($id);
        $comentarios = AvaliacaoComentario::where('estabelecimento_id', $estabelecimento->id)->with('usuario')->get();
        return view('saibaMais', compact('estabelecimento', 'comentarios'));
    }
}
