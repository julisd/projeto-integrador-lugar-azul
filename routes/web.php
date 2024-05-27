<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Estabelecimento\EstabelecimentoAuthController;
use App\Http\Controllers\Estabelecimento\AvaliacaoController;
use App\Http\Controllers\Pessoa\PessoaAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/estabelecimento/{id}/comentarios', [AvaliacaoController::class, 'mostrarComentarios'])->name('estabelecimento.comentarios');
Route::post('/responder-avaliacao', [AvaliacaoController::class, 'responderComentario'])->name('responderComentario');

Route::prefix('estabelecimento')->group(function () {
    Route::get('home', [EstabelecimentoAuthController::class, 'home'])->name('estabelecimento.home');
    Route::get('login', [EstabelecimentoAuthController::class, 'showLoginForm'])->name('estabelecimento.login');
    Route::post('login', [EstabelecimentoAuthController::class, 'login'])->middleware('guest:estabelecimento');
    Route::get('register', [EstabelecimentoAuthController::class, 'showRegistrationForm'])->name('estabelecimento.register');
    Route::post('register', [EstabelecimentoAuthController::class, 'register']);
    Route::get('verify', [EstabelecimentoAuthController::class, 'showVerificationForm'])->name('estabelecimento.verify')->middleware('auth:estabelecimento'); 
    Route::get('editar', [EstabelecimentoAuthController::class, 'editar'])->name('editarContaEstabelecimento')->middleware('auth:estabelecimento');
    Route::put('editar', [EstabelecimentoAuthController::class, 'update'])->name('estabelecimento.atualizarConta')->middleware('auth:estabelecimento');
    Route::post('/excluir', [EstabelecimentoAuthController::class, 'excluirConta'])->name('excluirContaEst');
    Route::post('/excluirConta', [EstabelecimentoAuthController::class, 'excluirConta'])->name('excluirContaEstabelecimento');  
    Route::post('/logout', [EstabelecimentoAuthController::class, 'logout'])->name('estabelecimento.logout');
    Route::get('/estabelecimento/{id}', [EstabelecimentoAuthController::class, 'show'])->name('estabelecimento.show');
});

// Rota para obter as características do usuário
Route::get('/obter-caracteristicas-usuario', [EstabelecimentoAuthController::class, 'obterCaracteristicasUsuario'])->name('estabelecimento.obterCaracteristicasUsuario');
Route::get('/obter-enderecos', [EstabelecimentoAuthController::class, 'getEnderecos'])->name('estabelecimento.getEnderecos');
Route::get('/obter-todos-estabelecimentos-ativos', [EstabelecimentoAuthController::class, 'getAllActiveEstabelecimentos'])->name('estabelecimento.getAllActiveEstabelecimentos');
Route::get('/obter-categorias', [EstabelecimentoAuthController::class, 'getCategories'])->name('estabelecimento.getCategories');
Route::get('/obter-estabelecimentos-por-categoria', [EstabelecimentoAuthController::class, 'getEstabelecimentosPorCategoria'])->name('estabelecimento.getEstabelecimentosPorCategoria');
Route::get('/obter-dados-estabelecimento', [EstabelecimentoAuthController::class, 'obterDadosEstabelecimento']);
Route::get('/detalhes-estabelecimento/{id}', [EstabelecimentoAuthController::class, 'detalhes'])->name('detalhes');
Route::get('/contato', [EstabelecimentoAuthController::class, 'contato']);
Route::post('/avaliar-estabelecimento', [AvaliacaoController::class, 'criarAvaliacao'])->name('criarAvaliacao');
Route::get('/comentarios/{idDoEstabelecimento}', [AvaliacaoController::class, 'buscarComentarios']);
Route::get('/estabelecimento/{id}', [EstabelecimentoAuthController::class, 'horarioEstabelecimento'])->name('estabelecimento.horarioEstabelecimento');
Route::get('/obter-todos-estabelecimentos-ativos-sem-caracteristicas', [EstabelecimentoAuthController::class, 'obterTodosEstabelecimentosAtivosSemCaracteristicas']);

Route::get('auth/estabelecimento/passwords/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('estabelecimento.password.request');
Route::post('auth/estabelecimento/passwords/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('estabelecimento.password.email');
Route::get('auth/estabelecimento/passwords/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('estabelecimento.password.reset');
Route::post('auth/estabelecimento/passwords/reset', [ResetPasswordController::class, 'resetPassword'])->name('estabelecimento.password.update');


Route::prefix('pessoa')->group(function () {
    Route::get('login', [PessoaAuthController::class, 'showLoginForm'])->name('pessoa.login');
    Route::post('login', [PessoaAuthController::class, 'login']); 
    Route::get('register', [PessoaAuthController::class, 'showRegistrationForm'])->name('pessoa.register');
    Route::post('register', [PessoaAuthController::class, 'register']); 
    Route::get('verify', [PessoaAuthController::class, 'showVerificationForm'])->name('pessoa.verify')->middleware('auth:pessoa_usuaria'); 
    Route::get('password/confirm', [PessoaAuthController::class, 'showConfirmPasswordForm'])->name('pessoa.password.confirm')->middleware('auth:pessoa_usuaria'); 
    Route::get('/usuario/editar', [PessoaAuthController::class, 'editar'])->name('editarConta')->middleware('auth:pessoa_usuaria');
    Route::put('/usuario/editar', [PessoaAuthController::class, 'update'])->name('pessoa.atualizarConta')->middleware('auth:pessoa_usuaria');
    Route::post('logout', [PessoaAuthController::class, 'logout'])->name('logout');
    Route::get('/pessoa/home', [PessoaAuthController::class, 'home'])->name('pessoa.home')->middleware('auth:pessoa_usuaria');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('pessoa.password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('pessoa.password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'resetPassword'])->name('pessoa.password.update');
    Route::get('home', [PessoaAuthController::class, 'home'])->name('pessoa.home')->middleware('auth:pessoa_usuaria');
    Route::post('/usuario/excluir', [PessoaAuthController::class, 'excluirConta'])->name('excluirConta')->middleware('auth:pessoa_usuaria');
    Route::post('/excluir-conta', [PessoaAuthController::class, 'excluirConta'])->name('excluirConta')->middleware('auth:pessoa_usuaria');
});
Route::prefix('admin')->group(function () {
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    Route::post('/register', [AdminController::class, 'registerAdmin']);
    Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register');
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('editar', [AdminController::class, 'editar'])->name('admin.editarConta')->middleware('auth:admin');
    Route::put('editar', [AdminController::class, 'update'])->name('admin.atualizarConta')->middleware('auth:admin');
    Route::post('/excluir', [AdminController::class, 'excluirConta'])->name('admin.excluir');
    Route::post('/excluirConta', [AdminController::class, 'excluirConta'])->name('admin.excluirConta')->middleware('auth:admin');  
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/verificarEstabelecimentos', [AdminController::class, 'verificarEstabelecimentos'])->name('admin.verificarEstabelecimentos')->middleware('auth:admin');
    Route::match(['get', 'post'], '/aprovarEstabelecimento/{id}', [AdminController::class, 'aprovarEstabelecimento'])->name('admin.aprovarEstabelecimento')->middleware('auth:admin');
    Route::match(['get', 'post'], '/negarEstabelecimento/{id}', [AdminController::class, 'negarEstabelecimento'])->name('admin.negarEstabelecimento');
    Route::get('/estabelecimento/{id}', [AdminController::class, 'detalhesEstabelecimento'])->name('admin.detalhesEstabelecimento');
});