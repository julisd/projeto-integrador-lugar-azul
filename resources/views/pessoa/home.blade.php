@extends('layout.app', ['current' => 'home'])
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Estabelecimentos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-search {
            width: 100%;
        }

        .btn-list,
        .btn-map {
            width: 100%;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 40px;
            border-radius: 5px;
        }

        .btn-list i,
        .btn-map i {
            margin-right: 5px;
        }

        .btn-list span,
        .btn-map span {
            font-weight: bold;
        }

        .map-container,
        .list-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            display: none;
        }

        .list-container {
            padding: 20px;
        }

        #map {
            height: 300px;
            /* Altura padrão do mapa */
            border-radius: 8px;
            overflow: hidden;
        }

        #message-container {
            display: none;
            text-align: center;
            /* Centraliza o conteúdo horizontalmente */
            margin-top: 20px;
            /* Espaçamento superior */
        }

        .message-box {
            background-color: #f0f0f0;
            /* Cor de fundo */
            border-radius: 10px;
            /* Borda arredondada */
            padding: 20px;
            /* Espaçamento interno */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Sombra */
        }

        .estabelecimento-card {
            width: 100%;
        }


        .card-body.estabelecimento-name,
        .card-body.estabelecimento-category,
        .card-body.estabelecimento-endereco {
            font-size: 16px;
        }


        @media (min-width: 768px) {

            .map-container,
            .list-container {
                display: block;
            }
        }
    </style>
</head>

<body>
    @section('content')
    <div class="container">
        <div class="header">
            <h1>Pesquisar Estabelecimentos</h1>
        </div>
        <div class="form-container">
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" class="form-control" id="city" placeholder="Digite sua cidade">
            </div>
            <div class="form-group">
                <label for="category">Categoria:</label>
                <select class="form-control" id="category">
                    <option value="all">Tudo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="consider-characteristics">Considerar Características:</label>
                <input type="checkbox" id="consider-characteristics" checked>
            </div>


            <button class="btn btn-primary btn-search" onclick="searchPlaces()">Procurar</button>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <button class="btn btn-secondary btn-list active" onclick="toggleView('list')">
                    <i class="fas fa-list"></i>
                    <span>Ver Lista</span>
                </button>
                <button class="btn btn-secondary btn-map" onclick="toggleView('map')">
                    <i class="fas fa-map"></i>
                    <span>Ver Mapa</span>
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div id="map" style="margin-bottom: 20px;"></div>
                <div id="estabelecimentos-list" style="display:none;"></div>
            </div>
        </div>

    </div>
    <script>
        let map;
        let estabelecimentosList;
        let infowindow;
        let markers = [];
        var imageBasePath = "{{ asset('uploads/') }}";

        function initMap() {
            const blumenauCoords = {
                lat: -26.9196,
                lng: -49.0650
            };
            map = new google.maps.Map(document.getElementById('map'), {
                center: blumenauCoords,
                zoom: 12
            });
            estabelecimentosList = document.getElementById('estabelecimentos-list');
            infowindow = new google.maps.InfoWindow();
            getCategories();
        }

        function createMarker(location, title, id, map, content) {
            const marker = new google.maps.Marker({
                map,
                position: location,
                title,
                id
            });
            const infowindow = new google.maps.InfoWindow({
                content
            });
            marker.addListener('click', () => {
                infowindow.open(map, marker);
                loadEstabelecimentoInfo(id);
            });
            return marker;
        }

        function toggleView(view) {
            const mapContainer = document.getElementById('map');
            const listContainer = document.getElementById('estabelecimentos-list');
            const btnList = document.querySelector('.btn-list');
            const btnMap = document.querySelector('.btn-map');

            if (view === 'list') {
                listContainer.style.display = 'block';
                mapContainer.style.display = 'none';
                btnList.classList.add('active');
                btnMap.classList.remove('active');
            } else if (view === 'map') {
                mapContainer.style.display = 'block';
                listContainer.style.display = 'none';
                btnMap.classList.add('active');
                btnList.classList.remove('active');
            }
        }


        function addEstabelecimentoToList(estabelecimento) {
            clearMarkers();
            const address = `${estabelecimento.endereco.logradouro}, ${estabelecimento.endereco.numero}, ${estabelecimento.endereco.bairro}, ${estabelecimento.endereco.cidade}, ${estabelecimento.endereco.uf}`;
            if (!address) {
                console.error('Endereço não encontrado para o estabelecimento:', estabelecimento.name);
                return;
            }
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                address
            }, (results, status) => {
                if (status === 'OK') {
                    const position = results[0].geometry.location;

                    // Adiciona marcador ao mapa
                    const marker = createMarker(position, estabelecimento.name, estabelecimento.endereco.id, map, `
                <div>
                    <strong>${estabelecimento.name}</strong><br>
                    Categoria: ${estabelecimento.category}<br>
                    Endereço: ${address}<br>
                    <a href="/detalhes-estabelecimento/${estabelecimento.endereco.id}">Saiba mais</a>
                    
                </div>
            `);
                    markers.push(marker);



                    // Dentro do loop de criação do card

                     // Cria elemento na lista
                     const listItem = document.createElement('div');
                    listItem.classList.add('card', 'mb-3', 'estabelecimento-card');
                    const image = document.createElement('div');
                    const imageSrc = imageBasePath + '/' + estabelecimento.image;
                    image.src = imageSrc;
                    image.alt = estabelecimento.name;
                    image.style.width = '70px';
                    image.style.height = '70px';
                    const name = document.createElement('div');
                    name.classList.add('estabelecimento-name');
                    name.textContent = estabelecimento.name;
                    const category = document.createElement('div');
                    category.classList.add('estabelecimento-category');
                    category.textContent = estabelecimento.category;
                    const endereco = document.createElement('div');
                    endereco.classList.add('estabelecimento-endereco');
                    endereco.textContent = address;
                    const saibaMaisLink = document.createElement('a');
                    saibaMaisLink.href = '/detalhes-estabelecimento/' + estabelecimento.endereco.id;
                    saibaMaisLink.textContent = 'Saiba mais';
                    const br = document.createElement('br'); // Adicionando um elemento <br>



                    listItem.appendChild(image);
                    listItem.appendChild(name);
                    listItem.appendChild(category);
                    listItem.appendChild(endereco);
                    listItem.appendChild(saibaMaisLink);
                    listItem.appendChild(br);

                    listItem.addEventListener('click', () => {
                        loadEstabelecimentoInfo(estabelecimento.endereco.id);
                    });

                    estabelecimentosList.appendChild(listItem);
                } else {
                    console.error('Erro ao geocodificar endereço:', status);
                }
            });
        }


        function addAllMarkersAndList(city) {
            clearMarkers();
            estabelecimentosList.innerHTML = '';
            markers = [];
            fetch(`/obter-todos-estabelecimentos-ativos?city=${city}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(estabelecimento => {
                        addEstabelecimentoToList(estabelecimento);
                    });
                })
                .catch(error => console.error('Erro ao obter estabelecimentos ativos:', error));
        }



        function clearMarkers() {
            markers.forEach(marker => marker.setMap(null));
        }

        function getCategories() {
            fetch('/obter-categorias')
                .then(response => response.json())
                .then(categories => {
                    const categoryDropdown = document.getElementById('category');
                    categoryDropdown.innerHTML = '';
                    const allOption = document.createElement('option');
                    allOption.value = 'all';
                    allOption.textContent = 'Tudo';
                    categoryDropdown.appendChild(allOption);
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category;
                        option.textContent = category;
                        categoryDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao obter categorias:', error));
        }

        function loadEstabelecimentoInfo(id) {
            console.log(`Carregando informações para o estabelecimento com ID ${id}...`);
            fetch(`/obter-dados-estabelecimento?id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter os dados do estabelecimento');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Dados do estabelecimento obtidos:', data);
                    const estabelecimentoInfo = `Nome: ${data.name}, Descrição: ${data.description}, Endereço: ${data.endereco}`;
                    showEstabelecimentoInfo(estabelecimentoInfo);
                })
                .catch(error => {
                    console.error('Erro durante a solicitação do estabelecimento:', error);
                });
        }

        function showEstabelecimentoInfo(info) {
            if (infowindow) {
                infowindow.close();
            }
            infowindow = new google.maps.InfoWindow({
                content: info
            });
            infowindow.open(map);
        }

        function addAllMarkersAndListWithoutCharacteristics(city) {
            clearMarkers();
            estabelecimentosList.innerHTML = '';
            markers = [];
            fetch(`/obter-todos-estabelecimentos-ativos-sem-caracteristicas?city=${city}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(estabelecimento => {
                        addEstabelecimentoToList(estabelecimento);
                    });
                })
                .catch(error => console.error('Erro ao obter estabelecimentos ativos:', error));
        }



        function searchPlaces() {
            clearMarkers();
            // Obtém os valores de cidade e categoria do HTML
            const city = document.getElementById('city').value;
            const category = document.getElementById('category').value;
            const considerCharacteristics = document.getElementById('consider-characteristics').checked;

            console.log('Cidade selecionada:', city);
            console.log('Categoria selecionada:', category);
            console.log('Considerar características:', considerCharacteristics);

            if (city === '') {
                alert('Por favor, digite uma cidade.');
                return;
            }

            if (category === 'all') {
                console.log('Obtendo todos os estabelecimentos ativos...');
                if (considerCharacteristics) {
                    // Se considerar características, adicione os estabelecimentos com base nas características do usuário
                    console.log('Considerando características do usuário...');
                    addAllMarkersAndList(city);
                } else {
                    // Caso contrário, adicione todos os estabelecimentos sem considerar características
                    console.log('Não considerando características do usuário...');
                    addAllMarkersAndListWithoutCharacteristics(city);
                }
            } else {
                console.log('Obtendo estabelecimentos por categoria...');
                // Faz uma solicitação para obter os estabelecimentos por categoria, levando em consideração ou não as características do usuário, dependendo do valor do checkbox
                fetch(`/obter-estabelecimentos-por-categoria?category=${category}&city=${city}&consider_characteristics=${considerCharacteristics}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Resposta da solicitação de estabelecimentos:', data);

                        estabelecimentosList.innerHTML = '';
                        markers = [];

                        const estabelecimentos = data;
                        estabelecimentos.forEach(estabelecimento => {
                            addEstabelecimentoToList(estabelecimento);
                        });
                    })
                    .catch(error => console.error('Erro ao obter estabelecimentos:', error));
            }
        }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe5MaIMdFA_uVpuz59EnVu5lMThHOv9Ek&callback=initMap"></script>
    @endsection