<?php

namespace App\Http\Controllers\Pessoa;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Controllers\Controller;
use App\Models\PessoaUsuaria;
use Illuminate\Http\Request;
use App\Models\Endereco;
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
        return view('auth.pessoa.register', compact('characteristics'));
    }

    public function showLinkRequestForm()
    {
        return view('auth.pessoa.passwords.email');
    }

    public function editar()
    {
        $characteristics = $this->getAutismCharacteristics();
        return view('pessoa.editar', compact('characteristics'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $customMessages = [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está sendo usado.',
            'birthdate.required' => 'O campo data de nascimento é obrigatório.',
            'autism_characteristics.required' => 'Selecione pelo menos uma característica autista.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'As senhas não correspondem.',
        ];

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:pessoa_usuaria,email,' . $user->id,
            'birthdate' => 'required|date',
            'autism_characteristics' => 'required|array', // Garante que pelo menos uma opção foi selecionada
            'autism_characteristics.*' => 'in:Visual,Comunicação,Sensorial,Mental,Habilidades Sociais,Hiperfoco,Ansiedade,Estereotipias,Interesses Específicos',
            'password' => 'nullable|string|min:8|confirmed',
        ], $customMessages);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->birthdate = $request->birthdate;

        $selectedCharacteristics = implode(',', $request->input('autism_characteristics'));
        $user->autism_characteristics = $selectedCharacteristics;;
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
            'autism_characteristics' => 'array', // Certifique-se de que é um array
            'autism_characteristics.*' => 'in:Visual,Comunicação,Sensorial,Mental,Habilidades Sociais,Hiperfoco,Ansiedade,Estereotipias,Interesses Específicos',
        ]);


        $selectedCharacteristics = $request->input('autism_characteristics');

        PessoaUsuaria::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'birthdate' => $request->birthdate,
            'autism_characteristics' => implode(',', $selectedCharacteristics), // Converte o array em uma string, ajuste conforme necessário
        ]);


        return redirect(route('pessoa.login'))->with('success', 'Conta criada com sucesso! Faça o login.');
    }

    public function logout(Request $request)
    {
        Auth::guard('pessoa_usuaria')->logout();
        return redirect('/');
    }


    public function excluirConta(Request $request)
    {
        $user = Auth::guard('pessoa_usuaria')->user();

        Auth::guard('pessoa_usuaria')->logout();

        $user->delete();

        return redirect('/');
    }
}
