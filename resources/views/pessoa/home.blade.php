@extends('layout.app', ['current' => 'home'])

<style>
    /* Estilos personalizados */
    body {
        background-color: #f8f9fa;
        /* Cor de fundo geral */
    }

    .container {
        margin-top: 50px;
    }

    h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    .form-label {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #495057;
        /* Cor do texto do rótulo */
    }

    .form-control,
    .form-select {
        height: 50px;
        font-size: 1rem;
        border: 2px solid #ced4da;
        /* Cor da borda do campo de entrada */
    }

    .btn-primary {
        font-size: 1.2rem;
        padding: 12px 20px;
        background-color: #007bff !important;
        /* Cor de fundo do botão */
        border: 1px solid #007bff !important;
        /* Cor da borda do botão */
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        /* Cor de fundo do botão ao passar o mouse */
        border: 1px solid #0056b3 !important;
        /* Cor da borda do botão ao passar o mouse */
    }

    #map {
        width: 100%;
        height: 400px;
        border-radius: 8px;
        overflow: hidden;
    }

    .estabelecimento-card {
        background-color: #fff;
        /* Cor de fundo do cartão */
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: transform 0.3s ease-in-out;
    }

    .estabelecimento-card:hover {
        transform: scale(1.05);
    }

    .estabelecimento-name {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 5px;
        color: #212529;
        /* Cor do texto do nome do estabelecimento */
    }

    .estabelecimento-category {
        font-style: italic;
        color: #007bff;
        font-size: 1rem;
    }
</style>

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Pesquisar Estabelecimentos</h1>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4 col-lg-5">
            <!-- Opções de pesquisa -->
            <div class="mb-3 mr-2">
                <label for="city" class="form-label">Cidade:</label>
                <input type="text" class="form-control" id="city" placeholder="Digite sua cidade">
            </div>
        </div>
        <div class="col-md-4 col-lg-5">
            <div class="mb-3 mr-2">
                <label for="category" class="form-label">Categoria:</label>
                <select class="form-select form-control" id="category">
                    <option value="all">Tudo</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 d-flex" style="margin-top: 10px; align-items: center">
            <div class="">
                <!-- Botão de pesquisa -->
                <label></label>
                <button class="btn btn-primary btn-block" onclick="searchPlaces()">Procurar</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <!-- Mapa -->
            <div id="map"></div>
        </div>
        <div class="col-md-4">
            <h4>Lista de Estabelecimentos</h4>
            <div id="estabelecimentos-list"></div>
        </div>
    </div>
</div>
<script>
    let map;
    let estabelecimentosList = document.getElementById('estabelecimentos-list');
    let infowindow;
    let addedEstabelecimentos = [];
    let markers = [];

    function initMap() {
        const blumenauCoords = {
            lat: -26.9196,
            lng: -49.0650
        };
        map = new google.maps.Map(document.getElementById('map'), {
            center: blumenauCoords,
            zoom: 12
        });
        infowindow = new google.maps.InfoWindow();
        getCategories();
    }

    function createMarker(location, title, id, map, content) {
        const marker = new google.maps.Marker({
            map: map,
            position: location,
            title: title,
            id: id
        });

        const infowindow = new google.maps.InfoWindow({
            content: content
        });

        marker.addListener('click', () => {
            infowindow.open(map, marker);
            loadEstabelecimentoInfo(id);
        });

        return marker;
    }

    function addEstabelecimentoToList(estabelecimento) {
        const address = `${estabelecimento.endereco.logradouro}, ${estabelecimento.endereco.numero}, ${estabelecimento.endereco.bairro}, ${estabelecimento.endereco.cidade}, ${estabelecimento.endereco.uf}`;

        if (!address) {
            console.error('Endereço não encontrado para o estabelecimento:', estabelecimento.name);
            return;
        }

        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            address: address
        }, (results, status) => {
            if (status === 'OK') {
                const marker = createMarker(
                    results[0].geometry.location,
                    estabelecimento.name,
                    estabelecimento.endereco.id,
                    map,
                    `
                    <div>
                        <strong>${estabelecimento.name}</strong><br>
                        Categoria: ${estabelecimento.category}<br>
                        Endereço: ${address}<br>
                        <a href="/detalhes-estabelecimento/${estabelecimento.endereco.id}" target="_blank">Saiba mais</a>
                    </div>
                    `
                );

                markers.push(marker);

                const listItem = document.createElement('div');
                listItem.classList.add('estabelecimento-card');

                const name = document.createElement('div');
                name.classList.add('estabelecimento-name');
                name.textContent = estabelecimento.name;

                const category = document.createElement('div');
                category.classList.add('estabelecimento-category');
                category.textContent = estabelecimento.category;

                listItem.appendChild(name);
                listItem.appendChild(category);

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
        addedEstabelecimentos = [];

        fetch(`/obter-todos-estabelecimentos-ativos?city=${city}`)
            .then(response => response.json())
            .then(data => {
                const estabelecimentos = data;
                estabelecimentos.forEach(estabelecimento => {
                    addEstabelecimentoToList(estabelecimento);
                });
            })
            .catch(error => {
                console.error('Erro ao obter estabelecimentos ativos:', error);
            });
    }

    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }

    function getCategories() {
        fetch('/obter-categorias')
            .then(response => response.json())
            .then(data => {
                const categories = data;
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
            .catch(error => {
                console.error('Erro ao obter categorias:', error);
            });
    }

    function searchPlaces() {
        clearMarkers();
        estabelecimentosList.innerHTML = '';
        addedEstabelecimentos = [];

        const category = document.getElementById('category').value;
        const city = document.getElementById('city').value.trim();

        if (city === '') {
            alert('Por favor, digite uma cidade.');
            return;
        }

        if (category === 'all') {
            addAllMarkersAndList(city);
        } else {
            fetch(`/obter-estabelecimentos-por-categoria?category=${category}&city=${city}`)
                .then(response => response.json())
                .then(data => {
                    const estabelecimentos = data;
                    estabelecimentos.forEach(estabelecimento => {
                        addEstabelecimentoToList(estabelecimento);
                    });
                })
                .catch(error => {
                    console.error('Erro ao obter estabelecimentos por categoria:', error);
                });
        }
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
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe5MaIMdFA_uVpuz59EnVu5lMThHOv9Ek&callback=initMap"></script>
@endsection