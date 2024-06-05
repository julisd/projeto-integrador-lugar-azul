@extends('layout.app')

@section('body')

<div class="bg-light d-flex align-items-center justify-content-center min-vh-100 page-home">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="card border border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Login de Usuário</h5>
                    </div>
                    <div class="card-body text-center">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('pessoa.login') }}">
                            @csrf
                            <div class="form-group text-left">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group text-left">
                                <label for="password">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </form>
                        <p>
                            <a href="{{ route('pessoa.password.request') }}">Esqueceu a senha?</a>
                        </p>
                        <p class="mt-3">
                            Ainda não tem uma conta? <a href="{{ route('pessoa.register') }}">Cadastre-se aqui</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection