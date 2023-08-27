<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Estabelecimento\EstabelecimentoAuthController as EstabelecimentoAuthController;
use App\Http\Controllers\Pessoa\PessoaAuthController as PessoaAuthController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas para Estabelecimento
Route::prefix('estabelecimento')->group(function () {
    Route::get('login', [EstabelecimentoAuthController::class, 'showLoginForm'])->name('estabelecimento.login');
    Route::post('login', [EstabelecimentoAuthController::class, 'login']);
    Route::get('home', [EstabelecimentoAuthController::class, 'home'])->name('estabelecimento.home');

    // ... outras rotas de autenticação para Estabelecimento
});

Route::prefix('pessoa')->group(function () {
    Route::get('login', [PessoaAuthController::class, 'showLoginForm'])->name('pessoa.login');
    Route::post('login', [PessoaAuthController::class, 'login'])->middleware('guest:pessoa_usuaria'); // Usando o middleware guest para garantir que usuários autenticados não acessem
    Route::get('register', [PessoaAuthController::class, 'showRegistrationForm'])->name('pessoa.register');
    Route::post('register', [PessoaAuthController::class, 'register'])->middleware('guest:pessoa_usuaria'); // Usando o middleware guest para garantir que usuários autenticados não acessem
    Route::get('verify', [PessoaAuthController::class, 'showVerificationForm'])->name('pessoa.verify')->middleware('auth:pessoa_usuaria'); // Usando o middleware auth para garantir que apenas usuários autenticados acessem
    Route::get('password/confirm', [PessoaAuthController::class, 'showConfirmPasswordForm'])->name('pessoa.password.confirm')->middleware('auth:pessoa_usuaria'); // Usando o middleware auth para garantir que apenas usuários autenticados acessem
    Route::get('/usuario/editar', [PessoaAuthController::class, 'editar'])->name('editarConta')->middleware('auth:pessoa_usuaria');
    Route::put('/usuario/editar', [PessoaAuthController::class, 'update'])->name('atualizarConta')->middleware('auth:pessoa_usuaria');
    Route::post('logout', [PessoaAuthController::class, 'logout'])->name('logout');
    Route::get('/pessoa/home', [PessoaAuthController::class, 'home'])->name('pessoa.home');
    Route::get('password/reset', [PessoaAuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [PessoaAuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [PessoaAuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('password/reset', [PessoaAuthController::class, 'resetPassword'])->name('password.update');
    Route::get('home', [PessoaAuthController::class, 'home'])->name('pessoa.home');
    Route::post('/usuario/excluir', [PessoaAuthController::class, 'excluirConta'])->name('excluirConta');
Route::post('/excluir-conta', [PessoaAuthController::class, 'excluirConta'])->name('excluirConta');

    // ... outras rotas de autenticação para Pessoa Usuária
});


