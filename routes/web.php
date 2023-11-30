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
    Route::post('register', [EstabelecimentoAuthController::class, 'register'])->middleware('guest:estabelecimento'); // Usando o middleware guest para garantir que usuários autenticados não acessem
    Route::get('verify', [EstabelecimentoAuthController::class, 'showVerificationForm'])->name('estabelecimento.verify')->middleware('auth:estabelecimento'); // Usando o middleware auth para garantir que apenas usuários autenticados acessem
    Route::get('password/confirm', [EstabelecimentoAuthController::class, 'showConfirmPasswordForm'])->name('estabelecimento.password.confirm')->middleware('auth:estabelecimento'); // Usando o middleware auth para garantir que apenas usuários autenticados acessem
    Route::get('home', [EstabelecimentoAuthController::class, 'home'])->name('estabelecimento.home');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('estabelecimento.password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('estabelecimento.password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('estabelecimento.password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('estabelecimento.password.update');
    Route::get('editar', [EstabelecimentoAuthController::class, 'editar'])->name('editarContaEstabelecimento')->middleware('auth:estabelecimento');
    Route::put('editar', [EstabelecimentoAuthController::class, 'update'])->name('estabelecimento.atualizarConta')->middleware('auth:estabelecimento');
    Route::post('/excluir', [EstabelecimentoAuthController::class, 'excluirConta'])->name('excluirContaEst');
    Route::post('/excluirConta', [EstabelecimentoAuthController::class, 'excluirConta'])->name('excluirContaEstabelecimento');  
    Route::post('/logout', [EstabelecimentoAuthController::class, 'logout'])->name('estabelecimento.logout');
    Route::get('/estabelecimento/{id}', [EstabelecimentoAuthController::class, 'show'])->name('estabelecimento.show');

});

Route::get('/obter-enderecos', [EstabelecimentoAuthController::class, 'getEnderecos'])->name('estabelecimento.getEnderecos');
Route::get('/obter-todos-estabelecimentos-ativos', [EstabelecimentoAuthController::class, 'getAllActiveEstabelecimentos'])->name('estabelecimento.getAllActiveEstabelecimentos');
Route::get('/obter-categorias', [EstabelecimentoAuthController::class, 'getCategories'])->name('estabelecimento.getCategories');
Route::get('/obter-estabelecimentos-por-categoria', [EstabelecimentoAuthController::class, 'getEstabelecimentosPorCategoria'])->name('estabelecimento.getEstabelecimentosPorCategoria');
Route::get('/obter-dados-estabelecimento', [EstabelecimentoAuthController::class, 'obterDadosEstabelecimento']);
Route::get('/detalhes-estabelecimento/{id}', [EstabelecimentoAuthController::class, 'detalhes'])->name('detalhes');
Route::get('/contato', [EstabelecimentoAuthController::class, 'contato']);
Route::post('/avaliar-estabelecimento', [AvaliacaoController::class, 'criarAvaliacao'])->name('criarAvaliacao.estabelecimento');
Route::get('/comentarios/{idDoEstabelecimento}', [AvaliacaoController::class, 'buscarComentarios']);

Route::prefix('pessoa')->group(function () {
    Route::get('login', [PessoaAuthController::class, 'showLoginForm'])->name('pessoa.login');
    Route::post('login', [PessoaAuthController::class, 'login'])->middleware('guest:pessoa_usuaria'); // Usando o middleware guest para garantir que usuários autenticados não acessem
    Route::get('register', [PessoaAuthController::class, 'showRegistrationForm'])->name('pessoa.register');
    Route::post('register', [PessoaAuthController::class, 'register'])->middleware('guest:pessoa_usuaria'); // Usando o middleware guest para garantir que usuários autenticados não acessem
    Route::get('verify', [PessoaAuthController::class, 'showVerificationForm'])->name('pessoa.verify')->middleware('auth:pessoa_usuaria'); // Usando o middleware auth para garantir que apenas usuários autenticados acessem
    Route::get('password/confirm', [PessoaAuthController::class, 'showConfirmPasswordForm'])->name('pessoa.password.confirm')->middleware('auth:pessoa_usuaria'); // Usando o middleware auth para garantir que apenas usuários autenticados acessem
    Route::get('/usuario/editar', [PessoaAuthController::class, 'editar'])->name('editarConta')->middleware('auth:pessoa_usuaria');
    Route::put('/usuario/editar', [PessoaAuthController::class, 'update'])->name('pessoa.atualizarConta')->middleware('auth:pessoa_usuaria');
    Route::post('logout', [PessoaAuthController::class, 'logout'])->name('logout');
    Route::get('/pessoa/home', [PessoaAuthController::class, 'home'])->name('pessoa.home');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('pessoa.password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('pessoa.password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('pessoa.password.update');
    Route::get('home', [PessoaAuthController::class, 'home'])->name('pessoa.home');
    Route::post('/usuario/excluir', [PessoaAuthController::class, 'excluirConta'])->name('excluirConta');
    Route::post('/excluir-conta', [PessoaAuthController::class, 'excluirConta'])->name('excluirConta');
});


Route::prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    Route::post('/register', [AdminController::class, 'registerAdmin']);
    Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register');
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->middleware('guest:admin');
    Route::get('editar', [AdminController::class, 'editar'])->name('admin.editarConta')->middleware('auth:admin');
    Route::put('editar', [AdminController::class, 'update'])->name('admin.atualizarConta')->middleware('auth:admin');
    Route::post('/excluir', [AdminController::class, 'excluirConta'])->name('admin.excluir');
    Route::post('/excluirConta', [AdminController::class, 'excluirConta'])->name('admin.excluirConta');  
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/verificarEstabelecimentos', [AdminController::class, 'verificarEstabelecimentos'])->name('admin.verificarEstabelecimentos');
    Route::match(['get', 'post'], '/aprovarEstabelecimento/{id}', [AdminController::class, 'aprovarEstabelecimento'])->name('admin.aprovarEstabelecimento');
    Route::post('/negarEstabelecimento/{id}', [AdminController::class, 'negarEstabelecimento'])->name('admin.negarEstabelecimento');
    Route::get('/estabelecimento/{id}', [AdminController::class, 'detalhesEstabelecimento'])->name('admin.detalhesEstabelecimento');


});

