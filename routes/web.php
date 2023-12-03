<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Estabelecimento\EstabelecimentoAuthController;
use App\Http\Controllers\Estabelecimento\AvaliacaoController;
use App\Http\Controllers\Pessoa\PessoaAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas para Estabelecimento
Route::prefix('estabelecimento')->group(function () {
    Route::get('login', [EstabelecimentoAuthController::class, 'showLoginForm'])->name('estabelecimento.login');
    Route::post('login', [EstabelecimentoAuthController::class, 'login'])->middleware('guest:estabelecimento');
    Route::get('register', [EstabelecimentoAuthController::class, 'showRegistrationForm'])->name('estabelecimento.register');
    Route::post('register', [EstabelecimentoAuthController::class, 'register'])->middleware('guest:estabelecimento'); 
    Route::get('verify', [EstabelecimentoAuthController::class, 'showVerificationForm'])
    ->name('estabelecimento.verify')
    ->middleware('auth:estabelecimento');

Route::get('password/confirm', [EstabelecimentoAuthController::class, 'showConfirmPasswordForm'])
    ->name('estabelecimento.password.confirm')
    ->middleware('auth:estabelecimento');

Route::get('home', [EstabelecimentoAuthController::class, 'home'])
    ->name('estabelecimento.home')
    ->middleware('guest:estabelecimento');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('estabelecimento.password.request')
    ->middleware('guest:estabelecimento');

Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('estabelecimento.password.email')
    ->middleware('guest:estabelecimento');

Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])
    ->name('estabelecimento.password.reset')
    ->middleware('guest:estabelecimento');

Route::get('editar', [EstabelecimentoAuthController::class, 'editar'])
    ->name('editarContaEstabelecimento')
    ->middleware('auth:estabelecimento');

Route::put('editar', [EstabelecimentoAuthController::class, 'update'])
    ->name('estabelecimento.atualizarConta')
    ->middleware('auth:estabelecimento');

Route::post('/excluir', [EstabelecimentoAuthController::class, 'excluirConta'])
    ->name('excluirContaEst')
    ->middleware('guest:estabelecimento');

Route::post('/excluirConta', [EstabelecimentoAuthController::class, 'excluirConta'])
    ->name('excluirContaEstabelecimento')
    ->middleware('guest:estabelecimento');

Route::post('/logout', [EstabelecimentoAuthController::class, 'logout'])
    ->name('estabelecimento.logout');

Route::get('/estabelecimento/{id}', [EstabelecimentoAuthController::class, 'show'])
    ->name('estabelecimento.show')
    ->middleware('guest:estabelecimento');


});

Route::get('/obter-enderecos', [EstabelecimentoAuthController::class, 'getEnderecos'])
    ->name('estabelecimento.getEnderecos')
    ->middleware('auth'); // Coloque o middleware adequado aqui, como 'auth' para rotas autenticadas ou 'guest' para rotas de convidados

Route::get('/obter-todos-estabelecimentos-ativos', [EstabelecimentoAuthController::class, 'getAllActiveEstabelecimentos'])
    ->name('estabelecimento.getAllActiveEstabelecimentos')
    ->middleware('auth');

Route::get('/obter-categorias', [EstabelecimentoAuthController::class, 'getCategories'])
    ->name('estabelecimento.getCategories')
    ->middleware('auth');

Route::get('/obter-estabelecimentos-por-categoria', [EstabelecimentoAuthController::class, 'getEstabelecimentosPorCategoria'])
    ->name('estabelecimento.getEstabelecimentosPorCategoria')
    ->middleware('auth');

Route::get('/obter-dados-estabelecimento', [EstabelecimentoAuthController::class, 'obterDadosEstabelecimento'])
    ->middleware('auth');

Route::get('/detalhes-estabelecimento/{id}', [EstabelecimentoAuthController::class, 'detalhes'])
    ->name('detalhes')
    ->middleware('auth');

Route::get('/contato', [EstabelecimentoAuthController::class, 'contato'])
    ->middleware('auth');

Route::post('/avaliar-estabelecimento', [AvaliacaoController::class, 'criarAvaliacao'])
    ->name('criarAvaliacao.estabelecimento')
    ->middleware('auth');

Route::get('/comentarios/{idDoEstabelecimento}', [AvaliacaoController::class, 'buscarComentarios'])
    ->middleware('auth');

Route::get('/estabelecimento/{id}', [EstabelecimentoAuthController::class, 'horarioEstabelecimento'])
    ->name('estabelecimento.horarioEstabelecimento')
    ->middleware('auth');



    Route::prefix('pessoa')->group(function () {
        Route::get('login', [PessoaAuthController::class, 'showLoginForm'])
            ->name('pessoa.login')
            ->middleware('guest:pessoa_usuaria'); // Apenas convidados podem acessar a tela de login
    
        Route::post('login', [PessoaAuthController::class, 'login'])
            ->middleware('guest:pessoa_usuaria'); // Apenas convidados podem fazer login
    
        Route::get('register', [PessoaAuthController::class, 'showRegistrationForm'])
            ->name('pessoa.register')
            ->middleware('guest:pessoa_usuaria'); // Apenas convidados podem acessar a tela de registro
    
        Route::post('register', [PessoaAuthController::class, 'register'])
            ->middleware('guest:pessoa_usuaria'); // Apenas convidados podem se registrar
    
        Route::get('verify', [PessoaAuthController::class, 'showVerificationForm'])
            ->name('pessoa.verify')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem acessar a verificação
    
        Route::get('password/confirm', [PessoaAuthController::class, 'showConfirmPasswordForm'])
            ->name('pessoa.password.confirm')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem acessar a confirmação de senha
    
        Route::get('/usuario/editar', [PessoaAuthController::class, 'editar'])
            ->name('editarConta')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem editar a conta
    
        Route::put('/usuario/editar', [PessoaAuthController::class, 'update'])
            ->name('pessoa.atualizarConta')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem atualizar a conta
    
        Route::post('logout', [PessoaAuthController::class, 'logout'])
            ->name('logout'); // Não é necessário middleware para fazer logout
    
        Route::get('/pessoa/home', [PessoaAuthController::class, 'home'])
            ->name('pessoa.home')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem acessar a home
    
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('pessoa.password.request');
    
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');
    
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])
            ->name('pessoa.password.reset');
    
        Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])
            ->name('pessoa.password.update');
    
        Route::get('home', [PessoaAuthController::class, 'home'])
            ->name('pessoa.home')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem acessar a home
    
        Route::post('/usuario/excluir', [PessoaAuthController::class, 'excluirConta'])
            ->name('excluirConta')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem excluir a conta
    
        Route::post('/excluir-conta', [PessoaAuthController::class, 'excluirConta'])
            ->name('excluirConta')
            ->middleware('auth:pessoa_usuaria'); // Apenas usuários autenticados podem excluir a conta
    });
    

    Route::prefix('admin')->group(function () {
        Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    
        Route::post('/register', [AdminController::class, 'registerAdmin']);
    
        Route::get('/register', [AdminController::class, 'showRegistrationForm'])
            ->name('admin.register')
            ->middleware('guest'); // Apenas convidados podem acessar a tela de registro de administração
    
        Route::get('/login', [AdminController::class, 'showLoginForm'])
            ->name('login')
            ->middleware('guest'); // Apenas convidados podem acessar a tela de login
    
        Route::post('/login', [AdminController::class, 'login'])
            ->middleware('guest:admin'); // Apenas convidados podem fazer login como admin
    
        Route::get('editar', [AdminController::class, 'editar'])
            ->name('admin.editarConta')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem editar a conta
    
        Route::put('editar', [AdminController::class, 'update'])
            ->name('admin.atualizarConta')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem atualizar a conta
    
        Route::post('/excluir', [AdminController::class, 'excluirConta'])
            ->name('admin.excluir')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem excluir a conta
    
        Route::post('/excluirConta', [AdminController::class, 'excluirConta'])
            ->name('admin.excluirConta')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem excluir a conta
    
        Route::post('/logout', [AdminController::class, 'logout'])
            ->name('admin.logout'); // Não é necessário middleware para fazer logout
    
        Route::get('/verificarEstabelecimentos', [AdminController::class, 'verificarEstabelecimentos'])
            ->name('admin.verificarEstabelecimentos')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem verificar estabelecimentos
    
        Route::match(['get', 'post'], '/aprovarEstabelecimento/{id}', [AdminController::class, 'aprovarEstabelecimento'])
            ->name('admin.aprovarEstabelecimento')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem aprovar estabelecimentos
    
        Route::post('/negarEstabelecimento/{id}', [AdminController::class, 'negarEstabelecimento'])
            ->name('admin.negarEstabelecimento')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem negar estabelecimentos
    
        Route::get('/estabelecimento/{id}', [AdminController::class, 'detalhesEstabelecimento'])
            ->name('admin.detalhesEstabelecimento')
            ->middleware('auth:admin'); // Apenas administradores autenticados podem ver detalhes do estabelecimento
    });
    

