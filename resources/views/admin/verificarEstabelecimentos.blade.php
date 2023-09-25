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
                <th>CNPJ</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($estabelecimentosPendentes as $estabelecimento)
            <tr>
                <td>
                    <a href="{{ route('admin.detalhesEstabelecimento', $estabelecimento->id) }}">
                        {{ $estabelecimento->name }}
                    </a>
                </td>
                <td>
                    <p>CNPJ: {{ $estabelecimento->cnpj }}</p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
