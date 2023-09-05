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
            'description.required' => 'Nos ajude a te conhecer. Fala mais sobre a sua empresa?'
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
        ], $customMessages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Estabelecimento::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'description' => $request->description,
            'category' => $request->category,
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
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cnpj = $request->cnpj;
        $user->description = $request->description;
        $user->category = $request->category;
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
    
}
