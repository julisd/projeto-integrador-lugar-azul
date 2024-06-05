@extends('layout.app', ['current' => 'home'])

@section('body')
<div class="bg-gradient d-flex align-items-center justify-content-center min-vh-100 page-home">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-body text-center">
                        <i class="fas fa-universal-access fa-3x mb-3 text-primary"></i>
                        <h2 class="card-title font-weight-bold">Bem-Vindo!</h2>
                        <p class="card-text">
                            Explore lugares inclusivos e acessíveis ou faça login como estabelecimento inclusivo.
                        </p>
                        <a href="{{ route('pessoa.login') }}" class="btn btn-primary btn-lg btn-block mb-3">Sou Usuário</a>
                        <a href="{{ route('estabelecimento.login') }}" class="btn btn-primary btn-lg btn-block">Sou Estabelecimento</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .custom-card {
        background-color: #1E90FF; /* Azul claro */
        border-radius: 15px; /* Borda arredondada do cartão */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 1); /* Sombra mais suave */
        transition: transform 0.3s ease-in-out;
    }

    .custom-card:hover {
        transform: scale(1.05); /* Efeito de escala no hover */
    }
</style>
