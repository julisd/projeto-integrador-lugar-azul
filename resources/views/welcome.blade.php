@extends('layout.app', ['current' => 'home'])

@section('body')

<div class="bg-light d-flex align-items-center justify-content-center min-vh-100 page-home">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border border-primary">
                    <div class="card-body text-center">
                        <h2 class="card-title">Seja Bem-Vindo</h2>
                        <p class="card-text">
                            Realize o login como usuário para descobrir lugares inclusivos e acessíveis, ou,
                            realize o login como estabelecimento inclusivo.
                        </p>
                        <a href="{{ route('pessoa.login') }}" class="btn btn-primary">Sou Usuário</a>
                        <a href="{{ route('estabelecimento.login') }}" class="btn btn-primary">Sou Estabelecimento</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
