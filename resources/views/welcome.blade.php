@extends('layout.app', ['current' => 'home'])

@section('body')
<div class="bg-gradient d-flex align-items-center justify-content-center min-vh-100 page-home">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded border-0">
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
