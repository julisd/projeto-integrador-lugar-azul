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
            'cnpj' => [
                'required',
                Rule::unique('estabelecimentos'),
                'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/',
            ],
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

        // Crie o endereço
        $endereco = Endereco::create([
            'cep' => $request->cep,
            'logradouro' => $request->logradouro,
            'numero' => $request->numero,
            'complemento' => $request->complemento,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'uf' => $request->uf,
        ]);

        $status = 'pendente';


        // Crie o estabelecimento associando o endereço
        Estabelecimento::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'description' => $request->description,
            'category' => $request->category,
            'endereco_id' => $endereco->id, // Associar o endereço criado ao estabelecimento
            'status' => $status, // Defina o status como "pendente"

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
            // 'cep' => 'required|string|regex:/^\d{5}-\d{3}$/',
            // 'logradouro' => 'required|string|max:255',
            // 'numero' => 'required|string|max:10',
            // 'complemento' => 'nullable|string|max:255',
            // 'bairro' => 'required|string|max:255',
            // 'cidade' => 'required|string|max:255',
            // 'uf' => 'required|string|max:2',
        ]);
        

        $user->name = $request->name;
        $user->email = $request->email;
        $user->cnpj = $request->cnpj;
        $user->description = $request->description;
        $user->category = $request->category;

     
        $user->save(); // Salvar o modelo principal e suas relações

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
}
