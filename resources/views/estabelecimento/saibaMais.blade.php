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
            background-color: #fff;
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
            color: #0056b3;
        }

        .navbar-nav .nav-link:hover {
            color: #fff;
            background-color: #0056b3;
        }

        .section {
            min-height: 10vh;
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

        .info-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .info-box i {
            font-size: 2rem;
            margin-bottom: 20px;
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

        .titulo-azul {
            color: #007bff;
            /* Cor azul */
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

        .card{
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

        .logo-pequena {
            width: 150px;
            /* Ajuste o tamanho conforme necessário */
            height: 150px;
            /* Ajuste o tamanho conforme necessário */
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

        .logo {
            width: 50px;
            /* Ajuste o tamanho conforme necessário */
            height: auto;
            /* Manter a proporção da imagem */
        }
    </style>
</head>

<body>

    <!-- Barra de navegação -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" id="logo">
                <img src="../../../images/icons/logo.png" alt="Logo do Lugar Azul" class="logo">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">

                    <li><a  href="/pessoa/home">Voltar ao Início</a></li>

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
                    <h1 class="mb-4">Sobre a Empresa</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="card p-4">
                        <div class="card-body">
                            <img src="{{ asset('uploads/' . $estabelecimento->image) }}" alt="Logo da Empresa" class="rounded-circle img-thumbnail mb-4 logo-pequena">

                            <div class="mb-4">
                                <h2>{{ $nomeDoEstabelecimento }}</h2>
                                <p class="lead">{{ $descricao }}</p>
                            </div>
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

    <!-- Seção Informações da Empresa -->
    <section id="informacoes-da-empresa" class="section">
        <div class="container">
            <h1 class="titulo-azul mb-4">Informações da Empresa</h1>
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
                        <p class="endereco-info">Localização: {{ $logradouro }}, {{ $numero }}, {{ $complemento }}</p>
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
    </section>

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