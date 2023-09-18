@extends('layout.app')

@section('content')
<div class="container">

    <div class="page-title">
        <br>
        <h1>Verificar Estabelecimentos Pendentes</h1>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Descrição</th>
                <th>CNPJ</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estabelecimentosPendentes as $estabelecimento)
            <tr>
                <td>{{ $estabelecimento->name }}</td>
                <td>{{ $estabelecimento->category }}</td>
                <td>{{ $estabelecimento->description }}</td>
                <td>{{ $estabelecimento->cnpj }}</td>
                <td>
                    <div class="d-flex">
                        <form action="{{ route('admin.aprovarEstabelecimento', $estabelecimento->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-aprovar mr-2">Aprovar</button>
                        </form>
                        <button type="button" class="btn btn-danger btn-negar" data-toggle="modal" data-target="#negarModal{{ $estabelecimento->id }}">
                            Negar
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Modal de Confirmação para Negar -->
            <div class="modal fade" id="negarModal{{ $estabelecimento->id }}" tabindex="-1" role="dialog" aria-labelledby="negarModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="negarModalLabel">Confirmar Negar Estabelecimento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja negar o estabelecimento {{ $estabelecimento->name }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <form action="{{ route('admin.negarEstabelecimento', $estabelecimento->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-negar">Negar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection