<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $nomeDoEstabelecimento }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            color: #0056b3;
        }

        .carousel-inner {
            background-color: #f8f9fa;
            padding: 20px;
            overflow: auto !important;
        }

        .carousel-caption {
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 20px;
        }


        .carousel-indicators {
            bottom: 10px;
        }

        .comentario {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }


        .info-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .info-box i {
            font-size: 2rem;
            color: #007bff;
        }

        .info-box h3 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #007bff;
        }

        .info-box p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0;
        }

        .info-box ul {
            list-style: none;
            padding-left: 0;
            margin-top: 20px;
        }

        .info-box ul li {
            margin-bottom: 10px;
        }

        .logo {
            width: 50px;
            height: auto;
        }

        .logo-pequena {
            width: 150px;
            height: 150px;
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

        .card {
            --bs-card-bg: #7aafff
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

        .section {
            text-align: center;


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

        .navbar-custom {
            background-color: #007bff;
            /* Cor de fundo da navbar */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: #ffffff;
            /* Cor do texto */
        }

        .navbar-custom .navbar-brand img {
            max-height: 40px;
            /* Altura máxima da imagem */
            margin-right: 10px;
            /* Espaçamento à direita da imagem */
        }

        /* Estilos para os carrosséis */
        .carousel-item {
            height: 100vh;
            min-height: 300px;
            background: no-repeat center center scroll;
            background-size: cover;
        }

        .carousel-caption {
            bottom: 20%;
        }

        .carousel-dark .carousel-control-prev-icon,
        .carousel-dark .carousel-control-next-icon {
            filter: invert(1);
        }

        .carousel-dark .carousel-indicators [data-bs-target] {
            background-color: #fff;
        }

        .carousel-dark .carousel-indicators .active {
            background-color: #000;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <!-- Logo e texto -->
            <a class="navbar-brand" href="#">
                <img src="../../../images/icons/logo.png" alt="Logo do Lugar Azul" class="logo">
                Lugar Azul
            </a>
            <!-- Botão de colapso para telas pequenas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Itens da navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#sobre" data-bs-target="#carouselExampleDark" data-bs-slide-to="0">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#avaliar" data-bs-target="#carouselExampleDark" data-bs-slide-to="1">Avaliar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#verComentarios" data-bs-target="#carouselExampleDark" data-bs-slide-to="2">Comentários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#informacoes-da-empresa" data-bs-target="#carouselExampleDark" data-bs-slide-to="3">Informações</a>
                    </li>
                    <li>
                        <a class="nav-link" href="/pessoa/home">Voltar ao Início</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Conteúdo do carrossel -->
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <!-- Indicadores -->
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slides -->
            <div id="sobre" class="carousel-item active" data-bs-interval="10000">
                <div class="section">
                    <h1>Sobre {{ $nomeDoEstabelecimento }}</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/' . $estabelecimento->image) }}" alt="Logo da Empresa" class="rounded-circle img-thumbnail mb-4 logo-pequena">
                            <div class="mb-4">
                                <p class="lead">{{ $descricao }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Avaliar -->
            <div id="avaliar" class="carousel-item" data-bs-interval="10000">
                <div class="section">
                    <h1>Avaliar {{ $nomeDoEstabelecimento }}</h1>
                    <p>Compartilhe sua experiência! Sua opinião é muito importante para nós.</p>
                    <!-- Formulário de avaliação -->
                    <form action="{{ route('criarAvaliacao') }}" method="POST">
                        @csrf
                        <input type="hidden" id="estabelecimento_id" name="estabelecimento_id" value="{{ $estabelecimento->id }}">

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

            <div id="verComentarios" class="carousel-item" data-bs-interval="10000">
                <div class="section">
                    <h1>Comentários sobre {{ $nomeDoEstabelecimento }} </h1>

                    <div id="mediaAvaliacoes"></div>

                    <select id="ordenarPor" onchange="ordenarComentarios()" style="margin-bottom: 20px;">
                        <option value="tudo">Todos</option>
                        <option value="recentes">Mais recentes</option>
                        <option value="maiorAvaliacao">Maior avaliação</option>
                        <option value="menorAvaliacao">Menor avaliação</option>
                    </select>

                    <!-- Lista para exibir os comentários -->
                    <div id="listaComentarios"></div>
                </div>
            </div>

            <!-- Informações da Empresa -->
            <div id="informacoes-da-empresa" class="carousel-item" data-bs-interval="10000">
                <div class="section">
                    <h1>Informações da Empresa {{ $nomeDoEstabelecimento }}</h1>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="fas fa-phone-alt mb-4"></i>
                                <h3>Contato</h3>
                                <p class="contato-info">Telefone: {{ $telefone }}</p>
                                <p>Envie-nos uma mensagem: {{ $email }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="fas fa-map-marker-alt mb-4"></i>
                                <h3>Endereço</h3>
                                <p class="endereco-info">Localização: {{ $logradouro }}, {{ $numero }}, {{ $complemento }}
                                </p>
                                <p>{{ $bairro }}, {{ $cidade }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="fas fa-clock mb-4"></i>
                                <h3>Horário de Funcionamento</h3>
                                <ul>
                                    @foreach($horariosEstabelecimento as $horario)
                                    <li>{{ $horario->dia_semana }}: Das {{ date('H:i', strtotime($horario->abertura)) }} às
                                        {{ date('H:i', strtotime($horario->fechamento)) }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <!-- Botões de controle -->
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Botão para abrir a barra de navegação -->
    <button class="navbar-toggler d-block d-lg-none fixed-bottom" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

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
            const idDoEstabelecimento = document.getElementById('estabelecimento_id').value;

            obterComentariosEstabelecimento(idDoEstabelecimento)
                .then(data => {
                    console.log('Dados obtidos:', data);

                    const mediaAvaliacoes = calcularMediaAvaliacoes(data.comentarios);
                    console.log('Média de Avaliações:', mediaAvaliacoes);
                    exibirMediaAvaliacoes(mediaAvaliacoes);

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
                        cardTitle.innerText = `Comentário por ${comentario.usuario_nome || 'Anônimo'}`;

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
                        cardDate.innerText = `Data: ${comentario.created_at}`;

                        cardBody.appendChild(cardTitle);
                        cardBody.appendChild(rating);
                        cardBody.appendChild(cardText);
                        cardBody.appendChild(cardDate);

                        // Adicionando respostas, se houver
                        if (comentario.respostas && comentario.respostas.length > 0) {
                            const respostaTitulo = document.createElement('h6');
                            respostaTitulo.innerText = 'Resposta do proprietário:';
                            respostaTitulo.style.fontWeight = 'bold';
                            cardBody.appendChild(respostaTitulo);

                            // Loop através das respostas
                            comentario.respostas.forEach(resposta => {
                                const respostaCard = document.createElement('div'); // Criando uma div para cada resposta
                                respostaCard.classList.add('respost'); // Adicionando classe resposta e background branco

                                const respostaText = document.createElement('p'); // Criando um parágrafo para o texto da resposta
                                respostaText.innerText = resposta.texto; // Adicionando o texto da resposta
                                respostaCard.appendChild(respostaText); // Adicionando o texto da resposta à div da resposta

                                const respostaDate = document.createElement('p'); // Criando um parágrafo para a data da resposta
                                respostaDate.innerText = `Data: ${resposta.created_at}`; // Adicionando a data da resposta
                                respostaCard.appendChild(respostaDate); // Adicionando a data da resposta à div da resposta

                                cardBody.appendChild(respostaCard); // Adicionando a div da resposta ao corpo do comentário
                            });
                        }

                        comentarioCard.appendChild(cardBody);
                        listaComentarios.appendChild(comentarioCard);
                    });


                })
                .catch(error => {
                    console.error('Erro ao obter os comentários:', error);
                });
        });

        function calcularMediaAvaliacoes(comentarios) {
            let totalAvaliacoes = 0;
            comentarios.forEach(comentario => {
                totalAvaliacoes += comentario.avaliacao;
            });
            const media = totalAvaliacoes / comentarios.length;
            return media; // A média já está na escala de 0 a 5
        }

        function exibirMediaAvaliacoes(media) {
            const mediaElement = document.getElementById('mediaAvaliacoes');
            if (mediaElement) {
                if (media !== null && !isNaN(media) && media > 0) {
                    // Converte a média para estrelas
                    let estrelas = '';
                    // Exibe apenas uma estrela
                    if (media >= 1) {
                        estrelas += '<i class="fas fa-star checked"></i>'; // Estrela preenchida
                    } else {
                        estrelas += '<i class="fas fa-star"></i>'; // Estrela vazia
                    }
                    // Exibe o valor da média com uma casa decimal após a vírgula
                    estrelas += `<span>${media.toFixed(1)}</span>`;
                    mediaElement.innerHTML = estrelas;
                } else {
                    mediaElement.innerHTML = '<p>Sem avaliações</p>';
                }
            }
        }


        function compararPorMaiorAvaliacao(a, b) {
            const avaliacaoA = a.querySelectorAll('.rating .checked').length;
            const avaliacaoB = b.querySelectorAll('.rating .checked').length;
            return avaliacaoB - avaliacaoA;
        }

        function compararPorMenorAvaliacao(a, b) {
            const avaliacaoA = a.querySelectorAll('.rating .checked').length;
            const avaliacaoB = b.querySelectorAll('.rating .checked').length;
            return avaliacaoA - avaliacaoB;
        }


        function compararPorDataRecente(a, b) {
            const regex = /Data: (\d{2})\/(\d{2})\/(\d{4})/; // Expressão regular para extrair data no formato "DD/MM/YYYY"
            const dataAString = a.querySelector('.card-date').innerText.trim();
            const dataBString = b.querySelector('.card-date').innerText.trim();

            // Extrair as partes da data usando a expressão regular
            const [, diaA, mesA, anoA] = regex.exec(dataAString);
            const [, diaB, mesB, anoB] = regex.exec(dataBString);

            // Criar objetos Date com as partes extraídas
            const dataA = new Date(parseInt(anoA), parseInt(mesA) - 1, parseInt(diaA));
            const dataB = new Date(parseInt(anoB), parseInt(mesB) - 1, parseInt(diaB));

            // Verificar se as datas são válidas
            if (isNaN(dataA.getTime()) || isNaN(dataB.getTime())) {
                console.error("Erro: Uma ou ambas as datas não são válidas.");
                return 0; // ou alguma outra ação adequada, dependendo do contexto
            }

            // Retornar a diferença de tempo entre as datas
            return dataB - dataA;
        }

        // Função para ordenar os comentários
        function ordenarComentarios() {
            console.log("Ordenando comentários...");

            // Obtém o critério de ordenação selecionado
            const criterio = document.getElementById('ordenarPor').value;
            console.log("Critério de ordenação:", criterio);

            // Obtém a lista de comentários
            const listaComentarios = document.getElementById('listaComentarios');

            // Obtém todos os comentários
            const comentarios = listaComentarios.querySelectorAll('.comentario');

            // Converte a NodeList em um array para facilitar a ordenação
            const arrayComentarios = Array.from(comentarios);

            // Verifica se o critério selecionado é "todos"
            if (criterio === 'tudo') {
                // Remove qualquer ordenação existente
                listaComentarios.innerHTML = ''; // Limpa a lista

                // Adiciona novamente os comentários na ordem original
                arrayComentarios.forEach(comentario => {
                    listaComentarios.appendChild(comentario);
                });
            } else {
                // Ordena os comentários com base no critério selecionado
                switch (criterio) {
                    case 'recentes':
                        arrayComentarios.sort(compararPorDataRecente);
                        break;
                    case 'maiorAvaliacao':
                        arrayComentarios.sort(compararPorMaiorAvaliacao);
                        break;
                    case 'menorAvaliacao':
                        arrayComentarios.sort(compararPorMenorAvaliacao);
                        break;
                    default:
                        console.log("Critério de ordenação não reconhecido:", criterio);
                }

                // Limpa a lista antes de reordenar os comentários
                listaComentarios.innerHTML = '';

                // Adiciona os comentários reordenados à lista
                arrayComentarios.forEach(comentario => {
                    listaComentarios.appendChild(comentario);
                });
            }
        }



        function formatarData(dataString) {
            const data = new Date(dataString);
            const options = {
                day: 'numeric',
                month: 'numeric',
                year: 'numeric'
            };
            return data.toLocaleDateString('pt-BR', options);
        }
    </script>
    <!-- Scripts do Bootstrap (coloque no final do body para carregamento mais rápido) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


</body>

</html>