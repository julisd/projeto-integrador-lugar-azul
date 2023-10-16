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

class EstabelecimentoAuthController extends Controller
{

    use SendsPasswordResetEmails;

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


    public function showLinkRequestForm()
    {
        return view('auth.estabelecimento.passwords.email');
    }

    public function showRegistrationForm()
    {
        return view('auth.estabelecimento.register');
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
        ], $customMessages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $estabelecimento = Estabelecimento::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'description' => $request->description,
            'category' => $request->category,
            'status' => 'pendente', // Defina o status como "pendente"
        ]);

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

        return redirect('/estabelecimento/login')->with('success', 'Conta criada com sucesso! Faça o login.');
    }

    public function home()
    {
        return view('estabelecimento.home');
    }

    public function editar()
    {
        return view('estabelecimento.editar');
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
        $user->cnpj = $request->cnpj;
        $user->description = $request->description;
        $user->category = $request->category;
        $user->status = 'pendente';


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
            $user->endereco->complemento = $request->complemento;
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

    public function getEnderecos()
    {
        // Recupere todos os endereços do banco de dados
        $enderecos = Endereco::all();

        return $enderecos;
    }

    public function getAllActiveEstabelecimentos(Request $request)
    {
        $city = $request->input('city');

        $estabelecimentos = Estabelecimento::where('status', 'aprovado')
            ->whereHas('endereco', function ($query) use ($city) {
                $query->where('cidade', $city);
            })
            ->with('endereco') // Certifique-se de carregar os endereços relacionados
            ->get();

        if ($estabelecimentos->isEmpty()) {
            \Log::info('Nenhum estabelecimento ativo encontrado na cidade: ' . $city);
        } else {
            foreach ($estabelecimentos as $estabelecimento) {
                \Log::info('Estabelecimento encontrado: ' . $estabelecimento->name);
            }
        }

        return $estabelecimentos;
    }


    public function getCategories()
    {
        $categories = Estabelecimento::distinct('category')->pluck('category');
        \Log::info('Categorias: ' . $categories);
        return response()->json($categories);
    }

    public function getEstabelecimentosPorCategoria(Request $request)
    {
        $category = $request->input('category');
        $city = $request->input('city');
    
        $estabelecimentos = Estabelecimento::where('status', 'aprovado')
            ->where('category', $category)
            ->whereHas('endereco', function ($query) use ($city) {
                $query->where('cidade', $city);
            })
            ->get();
    
        if ($estabelecimentos->isEmpty()) {
            \Log::info('Nenhum estabelecimento ativo encontrado na categoria ' . $category . ' na cidade ' . $city);
            return response()->json([]);
        } else {
            $estabelecimentosData = $estabelecimentos->map(function ($estabelecimento) {
                return [
                    'name' => $estabelecimento->name,
                    'category' => $estabelecimento->category,
                    'endereco' => $estabelecimento->endereco // Certifique-se de que 'endereco' está corretamente relacionado ao modelo
                ];
            });
            return response()->json($estabelecimentosData);
        }
    }
    
}
