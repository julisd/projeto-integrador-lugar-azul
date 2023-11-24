@extends('layout.app', ['current' => 'home'])

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Estilos personalizados */
    .estabelecimento-card {
        background-color: #f0f8ff;
        /* Cor de fundo */
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        /* Sombra */
        cursor: pointer;
        /* Cursor ao passar por cima */
    }

    .estabelecimento-name {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 5px;
    }

    .estabelecimento-category {
        font-style: italic;
        color: #007bff;
        /* Cor do texto */
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-12">
            <h1>Pesquisar Estabelecimentos</h1>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <!-- Opções de pesquisa -->
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" class="form-control" id="city" placeholder="Digite sua cidade">
            </div>
            <div class="form-group">
                <label for="category">Categoria:</label>
                <select class="form-control" id="category">
                    <option value="all">Tudo</option> <!-- Defina "Tudo" como a opção padrão -->
                </select>
            </div>
            <button class="btn btn-primary" onclick="searchPlaces()">Procurar</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Mapa -->
            <div id="map" style="height: 400px;"></div>
        </div>
        <div class="col-md-6">
            <h2>Lista de Estabelecimentos</h2>
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