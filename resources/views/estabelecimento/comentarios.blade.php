<style>
    /* Estilo para a seção de comentários */
    #verComentarios {
        padding: 50px 0;
    }

    /* Estilo para os cartões de comentários */
    .card.comentario {
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .card.comentario .card-body {
        padding: 20px;
    }

    /* Estilo para o título do comentário */
    .card.comentario .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Estilo para o texto do comentário */
    .card.comentario .card-text {
        margin-bottom: 10px;
    }

    /* Estilo para a data do comentário */
    .card.comentario .card-date {
        color: #999;
    }

    /* Estilo para o rating */
    .rating {
        margin-bottom: 10px;
    }

    .rating i {
        font-size: 20px;
        color: #ffc107;
        margin-right: 5px;
    }

    .rating .checked {
        color: #ffca28;
    }
</style>

<!-- Barra de navegação -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">
            <img src="../../../images/icons/logo.png" alt="Logo do Lugar Azul" class="logo">
        </a>
        <a class="lugarazul"> Lugar Azul </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">

                <li><a href="/estabelecimento/home">Voltar ao Início</a></li>

                </form>
                </li>
            </ul>
            </li>
            </ul>
        </div>
    </div>
</nav>



<div id="listaComentarios">
    @foreach($comentarios as $comentario)
    <div class="card comentario">
        <div class="card-body">
            <h5 class="card-title">Comentário por {{ $comentario['usuario_nome'] }}</h5>
            <div class="rating">
                @for ($i = 0; $i < $comentario['avaliacao']; $i++) <i class="fas fa-star checked"></i>
                    @endfor
            </div>
            <p class="card-text">{{ $comentario['comentario'] }}</p>
            <p class="card-date">Data: {{ $comentario['created_at'] }}</p>
            <!-- Formulário para responder ao comentário -->
            <!-- Formulário para responder ao comentário -->
            <form action="{{ route('responderComentario') }}" method="post" class="mt-3">
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

    // Função para renderizar os comentários na página
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

            const cardBody = document.createElement('div');
            cardBody.classList.add('card-body');

            const cardTitle = document.createElement('h5');
            cardTitle.classList.add('card-title');
            cardTitle.innerText = `Comentário por ${comentario.usuario_nome}`;

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
    }
</script>