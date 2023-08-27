<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estabelecimento;

class EstabelecimentoAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('estabelecimento.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/'); // Redireciona para a página principal após o login
        } else {
            return redirect()->back()->withErrors(['message' => 'E-mail ou senha incorretos']);
        }
    }

    public function showRegistrationForm()
    {
        return view('estabelecimento.register');
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
            'description.required' => 'Nos ajude a te conhecer. Fala mais sobre a sua empresa?'
        ];

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:estabelecimentos',
            'email' => 'required|string|email|unique:estabelecimentos',
            'password' => 'required|string|min:8|confirmed',
            'description' => 'required|string',
            'category' => 'required|string',
        ], $customMessages);

        Estabelecimento::create([
            'name' => $request->name,
            'cnpj' => $request->cnpj,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'descricao' => $request->description,
            'category' => $request->category,
        ]);

        return redirect('/estabelecimento/login')->with('success', 'Conta criada com sucesso! Faça o login.');
    }

    public function home()
    {    
        
    }

    // public function editar()
    // {
    //     return view('estabelecimento.editar');
    // }
    
    // public function update(Request $request)
    // {
       
    //     return redirect()->route('estabelecimento')->with('success', 'Cadastro atualizado com sucesso!');
    // }
    

}
