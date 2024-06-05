<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Mail;
use App\Mail\NegacaoEstabelecimento;


class AdminController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    public function home()
    {
        return view('admin.home');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        info('Tentativa de login com as seguintes credenciais:', $credentials);

        if (Auth::guard('admin')->attempt($credentials)) {
            info('Autenticação bem-sucedida.');
            return redirect()->intended('/admin/home');
        } else {
            info('Autenticação falhou.');
            return redirect()->back()->withErrors(['email' => 'Email não registrado ou senha incorreta.']);
        }
    }

    public function registerAdmin(Request $request)
    {
        $existingAdminCount = Admin::count();

        if ($existingAdminCount > 0) {
            // Já existe um administrador cadastrado, exibir mensagem
            return redirect()->route('admin.register')->with('warning', 'Já existe um administrador cadastrado. Favor entrar em contato com julisd3@gmail.com.');
        }

        // Validação dos dados de registro
        $customMessages = [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está sendo usado.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não correspondem.',
        ];

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admin',
            'password' => 'required|string|min:8|confirmed',
        ], $customMessages);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Conta de administrador criada com sucesso! Faça o login.');
    }

    public function showRegistrationForm()
    {
        return view('auth.admin.register');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout(); // Update to 'admin' guard
        return redirect('/');
    }

    public function excluirConta(Request $request)
    {
        $user = Auth::guard('admin')->user();

        Auth::guard('admin')->logout();

        $user->delete();

        return redirect('/');
    }

    public function detalhesEstabelecimento($id)
    {
        $estabelecimento = Estabelecimento::findOrFail($id);
        return view('admin.detalhesEstabelecimento', compact('estabelecimento'));
    }


    public function verificarEstabelecimentos()
    {
        // Recupere uma lista de contas pendentes (status 'pendente') de estabelecimentos
        $estabelecimentosPendentes = Estabelecimento::where('status', 'pendente')->with('endereco')->get();


        return view('admin.verificarEstabelecimentos', compact('estabelecimentosPendentes'));
    }

    public function negarEstabelecimento($id, Request $request)
    {
        $estabelecimento = Estabelecimento::findOrFail($id);
        $estabelecimento->status = 'negado';
        $estabelecimento->motivo_negacao = $request->motivo;
        $estabelecimento->save();
    
        // Adicione mensagens de debug
        info('Estabelecimento negado com sucesso.');
        info('Motivo de recusa: ' . $request->motivo);
    
        // Se o estabelecimento foi negado, redirecione com a mensagem de aviso
        return redirect()->route('admin.verificarEstabelecimentos')->with('negado', 'Estabelecimento negado com sucesso.');
    }
    
    public function aprovarEstabelecimento($id)
    {
        $estabelecimento = Estabelecimento::findOrFail($id);
        $estabelecimento->status = 'aprovado';
        $estabelecimento->save();
    
        // Adicione mensagem de debug
        info('Estabelecimento aprovado com sucesso.');
    
        // Se o estabelecimento foi aprovado, redirecione com a mensagem de aviso
        return redirect()->route('admin.verificarEstabelecimentos')->with('aprovado', 'Estabelecimento aprovado com sucesso.');
    }
    
    
    
}
