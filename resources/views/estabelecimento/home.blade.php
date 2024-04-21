@extends('layout.app', ['current' => 'home'])

@section('body')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-4">Bem-vindo, {{ Auth::guard('estabelecimento')->user()->name }}!</h5>

                    @if(session('warning'))
                    <div class="alert alert-warning mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Aviso:</strong> {{ session('warning') }}
                    </div>
                    @endif

                    @if(Auth::guard('estabelecimento')->user()->status == 'negado')
                    <div class="alert alert-danger mb-4" role="alert">
                        <i class="fas fa-times-circle"></i>
                        <strong>Cadastro Recusado:</strong> Infelizmente, o cadastro da sua empresa foi recusado.
                        <br>Motivo da recusa: {{ Auth::guard('estabelecimento')->user()->motivo_negacao }}
                        <br>Edite suas informações e aguarde a revisão do administrador.
                    </div>
                    @endif

                    @if(Auth::guard('estabelecimento')->user()->status == 'aprovado')
                    <div class="alert alert-success mb-4" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <strong>Cadastro Aprovado:</strong> {{ session('aprovado') }}
                        <br>Seu cadastro foi aprovado e agora todos os usuários irão ver sua empresa.
                    </div>
                    @endif

                    @if(Auth::guard('estabelecimento')->user()->status == 'pendente')
                    <div class="alert alert-info mb-4" role="alert">
                        <i class="fas fa-info-circle"></i>
                        <strong>Pendente de Aprovação:</strong> Seu cadastro está pendente de aprovação.
                        <br>Aguarde a revisão do administrador para que sua empresa seja ativada.
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection