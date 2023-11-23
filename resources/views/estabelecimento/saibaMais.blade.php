<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>{{ $nomeDoEstabelecimento }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #007bff;
            /* Cor de fundo da barra de navegação */
            color: #fff;
            /* Cor do texto na barra de navegação */
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
        }

        .navbar-nav .nav-link {
            padding: 10px 20px;
            margin: 0 5px;
            color: #000;
        }

        .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        /* Estilo para as seções */
        .section {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 60px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

        }



        /* Ajustes para títulos e parágrafos */
        .section h1 {
            font-size: 42px;
            margin-bottom: 30px;
            color: #333;
        }

        .section p {
            font-size: 20px;
            color: #555;
            line-height: 1.8;
        }

        /* Estilo para cada seção */
        #sobre {
            background-color: #f8f9fa;
        }

        #contato {
            background-color: #e9ecef;
        }

        #endereco {
            background-color: #dee2e6;
        }

        .section h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #333;
        }

        .section p {
            font-size: 18px;
            color: #555;
            line-height: 1.6;
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
                        <a class="nav-link" href="#contato">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#endereco">Endereço</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section id="sobre" class="section">
        <div class="container">
            <h1>Sobre Nós</h1>
            <p>{{ $descricao }}</p>
        </div>
    </section>

    <!-- Seção de Contato -->
    <section id="contato" class="section">
        <div class="container">
            <h1>Contato</h1>
            <p>
                Queremos estar mais perto de você!<br>
                Telefone: {{ $telefone }}<br>
                Envie-nos uma mensagem: {{ $email }}
            </p>
        </div>
    </section>

    <!-- Seção de Endereço -->
    <section id="endereco" class="section">
        <div class="container">
            <h1>Endereço</h1>
            <p>
                Estamos localizados no coração da cidade, um lugar onde a vida pulsa.<br>
                Venha nos visitar:<br>
                {{ $logradouro }}, {{ $numero }}, {{ $complemento }}<br>
                {{ $bairro }}, {{ $cidade }}
            </p>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Scroll suave para as seções ao clicar nos links do menu
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);

                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Simulação de função para obter informações do estabelecimento por ID
        function obterInformacoesEstabelecimentoPorID(id) {
            return fetch(`/obter-dados-estabelecimento?id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter os dados do estabelecimento');
                    }
                    return response.json();
                })
                .catch(error => {
                    console.error('Erro durante a solicitação do estabelecimento:', error);
                });
        }

        // Atualiza o nome e a descrição do estabelecimento na página
        function atualizarInformacoesEstabelecimento(idDoEstabelecimento) {
            const nomeDoEstabelecimento = document.getElementById('nomeDoEstabelecimento');
            const descricaoEstabelecimento = document.getElementById('descricaoEstabelecimento');

            // Chamada para buscar informações do estabelecimento por ID
            obterInformacoesEstabelecimentoPorID(idDoEstabelecimento)
                .then(dadosEstabelecimento => {
                    // Atualiza o nome e a descrição do estabelecimento na página
                    nomeDoEstabelecimento.textContent = dadosEstabelecimento.nome;
                    descricaoEstabelecimento.textContent = dadosEstabelecimento.descricao;
                });
        }

        // ID do estabelecimento desejado
        const idDoEstabelecimento = estabelecimento.id;
        atualizarInformacoesEstabelecimento(idDoEstabelecimento);
    </script>
</body>

</html>