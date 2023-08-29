<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary rounded">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item @if($current == 'home' && (Auth::guard('pessoa_usuaria')->check())) active @endif">
                    <a class="nav-link" href="{{ Auth::guard('pessoa_usuaria')->check() ? route('pessoa.home') : (Auth::guard('estabelecimento')->check() ? route('estabelecimento.home') : '/') }}">
                        Inicio
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @guest('pessoa_usuaria')
                @guest('estabelecimento')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/pessoa/login') }}">Sou Usuário</a>
                </li>
                @endguest
                @endguest

                @guest('estabelecimento')
                @guest('pessoa_usuaria')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/estabelecimento/login') }}">Sou Empresa</a>
                </li>
                @endguest
                @endguest

                @auth('pessoa_usuaria')
                <li class="nav-item dropdown">
                    <a id="navbarDropdownPessoa" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::guard('pessoa_usuaria')->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPessoa">
                        <a class="dropdown-item" href="{{ route('editarConta') }}">
                            {{ __('Editar Conta') }}
                        </a>

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#excluirContaModal">
                            {{ __('Excluir Conta') }}
                        </a>

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            {{ __('Sair') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endauth

                @auth('estabelecimento')
                <li class="nav-item dropdown">
                    <a id="navbarDropdownEstabelecimento" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::guard('estabelecimento')->user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownEstabelecimento">
                        <a class="dropdown-item" href="{{ route('editarContaEstabelecimento') }}">
                            {{ __('Editar Conta') }}
                        </a>

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#excluirContaModalEstabelecimento">
                            {{ __('Excluir Conta') }}
                        </a>

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            {{ __('Sair') }}
                        </a>

                        <form id="logout-form" action="{{ route('estabelecimento.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Modal de Confirmação de Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmar Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja sair?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('logout') }}" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão de Conta -->
    <div class="modal fade" id="excluirContaModal" tabindex="-1" role="dialog" aria-labelledby="excluirContaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="excluirContaModalLabel">Confirmar Exclusão de Conta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir sua conta? Essa ação é irreversível.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('excluirConta') }}" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('excluir-conta-form').submit();">
                        Excluir Conta
                    </a>
                    <form id="excluir-conta-form" action="{{ route('excluirConta') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>


     <!-- Modal de Confirmação de Logout Estabelecimento -->
     <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmar Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja sair?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('estabelecimento.logout') }}" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                    <form id="logout-form" action="{{ route('estabelecimento.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão de Conta Estabelecimento -->
    <div class="modal fade" id="excluirContaModalEstabelecimento" tabindex="-1" role="dialog" aria-labelledby="excluirContaModalLabelEstabelecimento" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="excluirContaModalLabelEstabelecimento">Confirmar Exclusão de Conta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir sua conta? Essa ação é irreversível.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('excluirContaEstabelecimento') }}" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('excluir-conta-form').submit();">
                        Excluir Conta
                    </a>
                    <form id="" action="{{ route('excluirContaEstabelecimento') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
</body>

</html>