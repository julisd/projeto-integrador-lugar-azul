<?php

namespace App\Http\Controllers\Pessoa;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use App\Models\PessoaUsuaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PessoaAuthController extends Controller
{

    use SendsPasswordResetEmails;

    public function showLoginForm()
    {
        return view('auth.pessoa.login');
    }

    public function home()
    {
        return view('pessoa.home');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('pessoa_usuaria')->attempt($credentials)) {
            // Autenticação bem-sucedida para PessoaUsuaria
            return redirect()->intended('/pessoa/home');
        } else {
            // Autenticação falhou
            return redirect()->back()->withErrors(['email' => 'Email não registrado ou senha incorreta.']);
        }
    }

    public function showRegistrationForm()
    {
        return view('auth.pessoa.register');
    }

    public function showLinkRequestForm()
    {
        return view('auth.pessoa.passwords.email');
    }

    public function editar()
    {
        return view('pessoa.editar');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:pessoa_usuaria,email,' . $user->id,
            'birthdate' => 'required|date',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->birthdate = $request->birthdate;
        $user->save();

        return redirect()->route('pessoa.home')->with('success', 'Perfil atualizado com sucesso!');
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
            'birthdate' => 'O campo data de nascimento é obrigatório',
        ];

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:pessoa_usuaria',
            'password' => 'required|string|min:8|confirmed',
            'birthdate' => 'required|date',
        ], $customMessages);

        PessoaUsuaria::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'birthdate' => $request->birthdate,

        ]);

        return redirect(route('pessoa.login'))->with('success', 'Conta criada com sucesso! Faça o login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('pessoa_usuaria')->logout(); // Logout para PessoaUsuaria
        return redirect('/');
    }


    public function excluirConta(Request $request)
    {
        $user = Auth::user();

        Auth::guard('pessoa_usuaria')->logout();

        // 3. Excluir o usuário
        $user->delete();

        return redirect('/');
    }
}
