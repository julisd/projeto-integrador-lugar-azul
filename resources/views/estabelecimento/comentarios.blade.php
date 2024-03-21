<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentários - Lugar Azul</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        /* Cor azul personalizada */
        :root {
            --azul-personalizado: #007bff;
            /* Azul Bootstrap */
            --azul-claro: #add8e6;
            /* Azul claro */
        }

        /* Estilo para a barra de navegação */
        .navbar {
            background-color: #f0f8ff;
        }

        .navbar-brand img {
            max-height: 30px;
        }

        /* Estilo para a seção de comentários */
        #listaComentarios {
            padding: 20px 0;
        }

        .rating i {
            font-size: 16px;
            color: #ffc107;
            margin-right: 3px;
        }

        .rating .checked {
            color: #ffca28;
        }

        /* Estilo para a seção de resposta */
        .resposta {
            background-color: #f0f0f0;
            /* Cor de fundo */
            padding: 10px 15px;
            border-radius: 10px;
            margin-top: 10px;
        }

        .resposta p {
            margin-bottom: 5px;
        }

        .comentario {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .comentario .card-body {
            padding: 15px;
        }

        .resposta {
            background-color: #f0f0f0;
            /* Cor de fundo */
            border-radius: 10px;
            margin-top: 10px;
        }


        .resposta-card {
            background-color: #f0f8ff;
            /* Azul claro */
            border: 1px solid #b0e0e6;
            /* Azul mais escuro */
            border-radius: 8px;
            margin-top: 10px;
        }

        .resposta-card .card-body {
            padding: 10px;
        }

        .resposta-card .card-text {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#" id="logo">
                <img src="../../../images/icons/logo.png" alt="Logo do Lugar Azul">
            </a>
            <a class="lugarazul" href="#">Lugar Azul</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/estabelecimento/home">Voltar ao Início</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="listaComentarios">
        @foreach($comentarios as $comentario)
        <div class="card comentario" data-comentario-id="{{ $comentario['id'] }}">
            <div class="card-body">
                <h5 class="card-title">Comentário por {{ $comentario['usuario_nome'] }}</h5>
                <div class="rating">
                    @for ($i = 0; $i < $comentario['avaliacao']; $i++) <i class="fas fa-star checked"></i>
                        @endfor
                </div>
                <p class="card-text">{{ $comentario['comentario'] }}</p>
                <p class="card-date">Data: {{ $comentario['created_at'] }}</p>

                <!-- Card de resposta -->
                @if(isset($comentario['respostas']))
                @foreach($comentario['respostas'] as $resposta)
                <div class="card resposta-card mt-3">
                    <div class="card-body">
                        <p class="card-text">{{ $resposta['texto'] }}</p>
                    </div>
                </div>
                @endforeach
                @endif

                <!-- Formulário para responder ao comentário -->
                <form action="{{ route('responderComentario') }}" method="post" class="mt-3" onsubmit="submeterResposta(event);">
                    @csrf
                    <input type="hidden" name="avaliacao_comentario_id" value="{{ $comentario['id'] }}">
                    <div class="form-group">
                        <label for="resposta">Resposta:</label>
                        <textarea name="resposta" id="resposta" class="form-control" rows="3" placeholder="Responda ao comentário"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Responder</button>
                </form>

            </div>
        </div>
        @endforeach
    </div>


    <script>
        // Função para fazer a requisição AJAX para obter os comentários do servidor
        function obterComentariosEstabelecimento(id) {
            return fetch(`/estabelecimento/${id}/comentarios`)
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

        // Função para formatar a data
        function formatarData(data) {
            const options = {
                day: 'numeric',
                month: 'numeric',
                year: 'numeric'
            };
            return new Date(data).toLocaleDateString('pt-BR', options);
        }

        function renderizarComentarios(comentarios) {
            const listaComentarios = document.getElementById('listaComentarios');
            if (!listaComentarios) {
                console.error('Elemento listaComentarios não encontrado.');
                return;
            }

            listaComentarios.innerHTML = '';

            comentarios.forEach(comentario => {
                const comentarioCard = document.createElement('div');
                comentarioCard.classList.add('card', 'comentario');

                // Renderizar conteúdo do comentário...

                // Verificar se há respostas
                if (comentario.resposta) {
                    const respostaCard = document.createElement('div');
                    respostaCard.classList.add('card', 'resposta');
                    const respostaCardBody = document.createElement('div');
                    respostaCardBody.classList.add('card-body');
                    const respostaText = document.createElement('p');
                    respostaText.classList.add('card-text');
                    respostaText.innerText = comentario.resposta;
                    respostaCardBody.appendChild(respostaText);
                    respostaCard.appendChild(respostaCardBody);
                    comentarioCard.appendChild(respostaCard);
                }

                listaComentarios.appendChild(comentarioCard);
            });
        }

        function submeterResposta(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                    method: form.method,
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao submeter resposta: ' + response.statusText);
                    }
                    return response.json(); // Supondo que o servidor responda com JSON
                })
                .then(data => {
                    const respostaTexto = formData.get('resposta');

                    if (respostaTexto) {
                        // Limpa o campo de resposta após submissão
                        form.querySelector('textarea[name="resposta"]').value = '';

                        // Encontra o card de comentário correspondente
                        const comentarioCard = form.closest('.comentario');

                        // Cria um novo card de resposta
                        const respostaCard = document.createElement('div');
                        respostaCard.classList.add('card', 'resposta-card', 'mt-3');
                        const cardBody = document.createElement('div');
                        cardBody.classList.add('card-body');
                        const cardText = document.createElement('p');
                        cardText.classList.add('card-text');
                        cardText.innerText = respostaTexto;
                        cardBody.appendChild(cardText);
                        respostaCard.appendChild(cardBody);

                        // Encontra a seção de respostas dentro do card de comentário
                        const respostasSection = comentarioCard.querySelector('.respostas-card');

                        // Insere o novo card de resposta antes do formulário de resposta
                        respostasSection.insertBefore(respostaCard, form);

                        // Rola a página para a resposta recém-adicionada
                        respostaCard.scrollIntoView({
                            behavior: 'smooth'
                        });

                    }
                })
        }
    </script>