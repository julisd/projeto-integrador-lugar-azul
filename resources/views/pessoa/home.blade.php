@extends('layout.app', ['current' => 'home'])

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
            <ul id="estabelecimentos-list" class="list-group"></ul>
        </div>
    </div>
</div>

<script>
    let map;
    let estabelecimentosList = document.getElementById('estabelecimentos-list');

    function initMap() {
        const blumenauCoords = {
            lat: -26.9196,
            lng: -49.0650
        }; // Coordenadas de Blumenau, SC
        map = new google.maps.Map(document.getElementById('map'), {
            center: blumenauCoords,
            zoom: 12 // Zoom inicial do mapa
        });

        getLocation();
        getCategories();
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

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                // Use userLocation para centrar o mapa ou realizar outras ações.
            });
        } else {
            alert("A geolocalização não é suportada pelo seu navegador.");
        }
    }

    let markers = [];

    function searchPlaces() {
        // Limpa os marcadores no mapa
        clearMarkers();

        estabelecimentosList.innerHTML = ''; // Limpa a lista de estabelecimentos ao pesquisar

        const category = document.getElementById('category').value;
        const city = document.getElementById('city').value;

        if (category === 'all') {
            addAllMarkersAndList(city); // Passa a cidade como parâmetro
        } else {
            fetch(`/obter-estabelecimentos-por-categoria?category=${category}&city=${city}`)
                .then(response => response.json())
                .then(data => {
                    const estabelecimentos = data;

                    estabelecimentos.forEach(estabelecimento => {
                        const address = `${estabelecimento.endereco.logradouro}, ${estabelecimento.endereco.numero}, ${estabelecimento.endereco.bairro}, ${estabelecimento.endereco.cidade}, ${estabelecimento.endereco.uf}`;
                        console.log("Endereço a ser geocodificado:", address);
                        if (address) {
                            const geocoder = new google.maps.Geocoder();
                            geocoder.geocode({
                                address: address
                            }, (results, status) => {
                                console.log("Resultado da geocodificação:", results);
                                if (status === 'OK') {
                                    const marker = new google.maps.Marker({
                                        map: map,
                                        position: results[0].geometry.location,
                                        title: estabelecimento.name
                                    });

                                    markers.push(marker); // Adiciona o marcador ao array de marcadores

                                    const listItem = document.createElement('li');
                                    listItem.textContent = `Nome: ${estabelecimento.name}, \br
                                    Categoria: ${estabelecimento.category}`;
                                    listItem.addEventListener('click', () => {
                                        google.maps.event.trigger(marker, 'click'); // Ativa o evento de clique do marcador ao clicar no item da lista
                                    });
                                    estabelecimentosList.appendChild(listItem);
                                } else {
                                    console.error('Erro ao geocodificar endereço:', status);
                                }
                            });
                        } else {
                            console.error('Endereço não encontrado para o estabelecimento:', estabelecimento.name);
                        }
                    });
                })
                .catch(error => {
                    console.error('Erro ao obter estabelecimentos por categoria:', error);
                });
        }
    }

    function addAllMarkersAndList(city) {
        fetch(`/obter-todos-estabelecimentos-ativos?city=${city}`)
            .then(response => response.json())
            .then(data => {
                const estabelecimentos = data;

                estabelecimentos.forEach(estabelecimento => {
                    const address = `${estabelecimento.endereco.logradouro}, ${estabelecimento.endereco.numero}, ${estabelecimento.endereco.bairro}, ${estabelecimento.endereco.cidade}, ${estabelecimento.endereco.uf}`;
                    console.log("Endereço a ser geocodificado:", address);
                    if (address) {
                        const geocoder = new google.maps.Geocoder();
                        geocoder.geocode({
                            address: address
                        }, (results, status) => {
                            console.log("Resultado da geocodificação:", results);
                            if (status === 'OK') {
                                const marker = new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location,
                                    title: estabelecimento.name
                                });

                                markers.push(marker); // Adiciona o marcador ao array de marcadores

                                const listItem = document.createElement('li');
                                listItem.textContent = `Nome: ${estabelecimento.name}, Categoria: ${estabelecimento.category}`;
                                listItem.addEventListener('click', () => {
                                    google.maps.event.trigger(marker, 'click'); // Ativa o evento de clique do marcador ao clicar no item da lista
                                });
                                estabelecimentosList.appendChild(listItem);
                            } else {
                                console.error('Erro ao geocodificar endereço:', status);
                            }
                        });
                    } else {
                        console.error('Endereço não encontrado para o estabelecimento:', estabelecimento.name);
                    }
                });
            })
            .catch(error => {
                console.error('Erro ao obter estabelecimentos ativos:', error);
            });
    }

    function clearMarkers() {
        // Limpa todos os marcadores do mapa e do array de marcadores
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe5MaIMdFA_uVpuz59EnVu5lMThHOv9Ek&callback=initMap"></script>
@endsection