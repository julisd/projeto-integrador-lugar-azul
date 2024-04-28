@extends('layout.app')
<style>
    .logo-pequena {
    width: 100px; /* Defina o tamanho desejado */
    height: 100px; /* Defina o tamanho desejado */
}
</style>
@section('content')
<div class="container">
    <div class="page-title mt-4">
        <h1>Detalhes do Estabelecimento</h1>
    </div>

    <div class="card mt-4">
    <div class="card-body">
        <h2 class="card-title">{{ $estabelecimento->name }}</h2>
        <p class="card-text"><strong>Categoria:</strong> {{ $estabelecimento->category }}</p>
        <p class="card-text"><strong>Descrição:</strong> {{ $estabelecimento->description }}</p>
        <p class="card-text"><strong>CNPJ:</strong> {{ $estabelecimento->cnpj }}</p>
        <p class="card-text"><strong>Telefone:</strong> {{ $estabelecimento->telephone }}</p>
        <p class="card-text"><strong>Logo da Empresa: </strong> </p>

        <img src="{{ asset('uploads/' . $estabelecimento->image) }}" alt="Logo da Empresa" class="rounded-circle img-thumbnail mb-4 logo-pequena">
        <p class="card-text"><strong>Características de Autismo:</strong> {{ $estabelecimento->autism_characteristics }}</p>

        <p class="card-text"><strong>Endereço:</strong></p>
        <ul class="list-unstyled">
            <p><strong>CEP:</strong> {{ $estabelecimento->endereco ? $estabelecimento->endereco->cep : 'N/A' }}</p>
            <li><strong>Logradouro:</strong> {{ $estabelecimento->endereco ? $estabelecimento->endereco->logradouro : 'N/A' }}</li>
            <li><strong>Número:</strong> {{ $estabelecimento->endereco ? $estabelecimento->endereco->numero : 'N/A' }}</li>
            <li><strong>Complemento:</strong> {{ $estabelecimento->endereco ? $estabelecimento->endereco->complemento : 'N/A' }}</li>
            <li><strong>Bairro:</strong> {{ $estabelecimento->endereco ? $estabelecimento->endereco->bairro : 'N/A' }}</li>
            <li><strong>Cidade:</strong> {{ $estabelecimento->endereco ? $estabelecimento->endereco->cidade : 'N/A' }}</li>
            <li><strong>UF:</strong> {{ $estabelecimento->endereco ? $estabelecimento->endereco->uf : 'N/A' }}</li>
        </ul>
        <div class="mt-3">
            <a href="{{ route('admin.aprovarEstabelecimento', $estabelecimento->id) }}" class="btn btn-success">Aprovar</a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#negarModal">Negar</button>
        </div>
    </div>
</div>

    <!-- Modal de Confirmação para Negar -->
    <div class="modal fade" id="negarModal" tabindex="-1" role="dialog" aria-labelledby="negarModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="negarModalLabel">Confirmar Negar Estabelecimento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.negarEstabelecimento', $estabelecimento->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="motivo">Motivo da Reprovação</label>
                            <textarea class="form-control" id="motivo" name="motivo" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Negar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
