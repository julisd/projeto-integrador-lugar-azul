<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>{{ $nomeDoEstabelecimento }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
            background-color: #f8f9fa;
            color: #333;
        }

        .navbar {
            background-color: #007bff;
            color: #fff;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
            color: #fff;
        }

        .navbar-nav .nav-link {
            padding: 10px 20px;
            margin: 0 5px;
            color: #fff;
        }

        .navbar-nav .nav-link:hover {
            color: #fff;
            background-color: #0056b3;
        }

        .section {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #007bff;
        }

        .section p {
            font-size: 1.25rem;
            color: #555;
            line-height: 1.6;
        }

        .comentario {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .comentario p {
            font-size: 1rem;
            color: #333;
            line-height: 1.6;
        }

        .comentario .card-date {
            font-size: 0.875rem;
            color: #666;
        }

        .rating {
            display: flex;
            justify-content: center;
            font-size: 24px;
        }

        .fa-star {
            cursor: pointer;
            transition: color 0.2s;
        }

        .fa-star:hover,
        .fa-star.checked {
            color: gold;
        }

        .ver-avaliacoes {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1.2rem;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .ver-avaliacoes:hover {
            background-color: #0056b3;
        }

        .contato-info,
        .endereco-info {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }
    </style>
</head>

<body>

    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" id="nomeDoEstabelecimento">{{ $nomeDoEstabelecimento }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#sobre">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#avaliar">Avaliação</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Área do Cliente
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/pessoa/home">Voltar ao Início</a></li>
                            <li>
                                <form action="{{ route('estabelecimento.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    <input type="hidden" id="idEstabelecimento" value="{{ $estabelecimento->id }}">
    <section id="sobre" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-4">Sobre Nós</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card p-4">
                        <div class="card-body">
                            <p class="card-text">{{ $descricao }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="avaliar" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h1>Avaliar</h1>
                    <p>Compartilhe sua experiência! Sua opinião é muito importante para nós.</p>
                    <div class="card p-4">
                        <form action="{{ route('criarAvaliacao.estabelecimento') }}" method="POST">
                            @csrf
                            <input type="hidden" name="estabelecimento_id" value="{{ $estabelecimento->id }}">
                            <div class="mb-3">
                                <label for="avaliacao" class="form-label">Sua Avaliação:</label>
                                <div class="rating">
                                    <input type="hidden" id="rating" name="avaliacao">
                                    <i class="fas fa-star" data-index="1"></i>
                                    <i class="fas fa-star" data-index="2"></i>
                                    <i class="fas fa-star" data-index="3"></i>
                                    <i class="fas fa-star" data-index="4"></i>
                                    <i class="fas fa-star" data-index="5"></i>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="comentario" class="form-label">Comentário:</label>
                                <textarea name="comentario" id="comentario" class="form-control" rows="4" cols="50"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
                <div></div>
                <div class="text-center mt-4"> <!-- Adicionei a classe "mt-4" para aplicar margem top -->
                    <p>Confira as opiniões de quem já esteve aqui!</p>
                    <a href="#verComentarios" class="btn btn-primary mt-4 ver-avaliacoes">Ver Avaliações <i class="fas fa-chevron-down"></i></a>
                </div>

            </div>
        </div>
    </section>

    <!-- Seção para ver os comentários -->
    <section id="verComentarios" class="section">
        <div class="container">
            <h1>Comentários</h1>

            <!-- Lista para exibir os comentários -->
            <div id="listaComentarios"></div>
        </div>
    </section>


    <!-- Rodapé -->
    <footer class="mt-5 py-3 text-center" style="background-color: #f8f9fa; color: #666; font-size: 0.9rem;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <!-- Seção de Contato -->
                    <h4>Contato</h4>
                    <p class="contato-info">
                        <strong>Telefone:</strong> {{ $telefone }}<br>
                        <strong>Envie-nos uma mensagem:</strong> {{ $email }}
                    </p>
                </div>
                <div class="col-md-4">
                    <!-- Seção de Endereço -->
                    <h4>Endereço</h4>
                    <p class="endereco-info">
                        <strong>Localização:</strong><br>
                        {{ $logradouro }}, {{ $numero }}, {{ $complemento }}<br>
                        {{ $bairro }}, {{ $cidade }}
                    </p>
                </div>
                <div class="col-md-4">
                    <!-- Seção de Horário de Funcionamento -->
                    <h4>Horário de Funcionamento</h4>
                    <p>
                        @foreach($horariosEstabelecimento as $horario)
                        <strong>{{ $horario->dia_semana }}:</strong> Das {{ date('H:i', strtotime($horario->abertura)) }} às {{ date('H:i', strtotime($horario->fechamento)) }}<br>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const stars = document.querySelectorAll('.fa-star');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const index = parseInt(star.getAttribute('data-index'));
                document.getElementById('rating').value = index;
                fillStars(index);
            });
        });

        function fillStars(index) {
            resetStars();
            for (let i = 0; i < index; i++) {
                stars[i].classList.add('checked');
            }
        }

        function resetStars() {
            stars.forEach(star => {
                star.classList.remove('checked');
            });
        }

        // Função para obter os comentários do estabelecimento
        function obterComentariosEstabelecimento(id) {
            return fetch(`/comentarios/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter os comentários do estabelecimento');
                    }
                    return response.json();
                })
                .catch(error => {
                    console.error('Erro ao buscar comentários:', error);
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const idDoEstabelecimento = document.getElementById('idEstabelecimento').value;

            obterComentariosEstabelecimento(idDoEstabelecimento)
                .then(data => {
                    const listaComentarios = document.getElementById('listaComentarios');
                    if (!listaComentarios) {
                        console.error('Elemento listaComentarios não encontrado.');
                        return;
                    }

                    listaComentarios.innerHTML = '';

                    data.comentarios.forEach(comentario => {
                        const comentarioCard = document.createElement('div');
                        comentarioCard.classList.add('card', 'comentario');

                        const cardBody = document.createElement('div');
                        cardBody.classList.add('card-body');

                        const cardTitle = document.createElement('h5');
                        cardTitle.classList.add('card-title');
                        cardTitle.innerText = `Comentário por ${comentario.usuario ? comentario.usuario.name : 'Anônimo'}`;

                        const rating = document.createElement('div');
                        rating.classList.add('rating');

                        for (let i = 0; i < comentario.avaliacao; i++) {
                            const star = document.createElement('i');
                            star.classList.add('fas', 'fa-star', 'checked');
                            rating.appendChild(star);
                        }

                        const cardText = document.createElement('p');
                        cardText.classList.add('card-text');
                        cardText.innerText = comentario.comentario;

                        const cardDate = document.createElement('p');
                        cardDate.classList.add('card-date');
                        cardDate.innerText = `Data: ${formatarData(comentario.created_at)}`;

                        cardBody.appendChild(cardTitle);
                        cardBody.appendChild(rating);
                        cardBody.appendChild(cardText);
                        cardBody.appendChild(cardDate);
                        comentarioCard.appendChild(cardBody);

                        listaComentarios.appendChild(comentarioCard);
                    });
                })
                .catch(error => {
                    console.error('Erro ao obter os comentários:', error);
                });
        });

        function formatarData(data) {
            const options = {
                day: 'numeric',
                month: 'numeric',
                year: 'numeric'
            };
            return new Date(data).toLocaleDateString('pt-BR', options);
        }
    </script>

</body>

</html>