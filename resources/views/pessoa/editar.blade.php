@extends('layout.app', ['current' => 'home'])

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Cadastro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pessoa.atualizarConta') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="row mb-3">
                            <label for="autism_characteristics" class="col-md-4 col-form-label text-md-end">{{ __('Características Autistas') }}</label>

                            <div class="col-md-6">
                                @foreach($characteristics as $key => $value)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="autism_characteristic_{{ $key }}" name="autism_characteristics[]" value="{{ $key }}">
                                    <label class="form-check-label" for="autism_characteristic_{{ $key }}">
                                        {{ $value }}
                                    </label>
                                </div>
                                @endforeach

                                @error('autism_characteristics')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birthdate">Data de Nascimento</label>
                            <input id="birthdate" type="date" class="form-control @error('birthdate') is-invalid @enderror" name="birthdate" value="{{ Auth::user()->birthdate }}" required>

                            @error('birthdate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Salvar Alterações') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection