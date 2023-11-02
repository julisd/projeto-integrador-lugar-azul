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
    let infowindow;
    let addedEstabelecimentos = [];
    let markers = [];

    function initMap() {
        const blumenauCoords = {
            lat: -26.9196,
            lng: -49.0650
        }; // Coordenadas de Blumenau, SC
        map = new google.maps.Map(document.getElementById('map'), {
            center: blumenauCoords,
            zoom: 12 // Zoom inicial do mapa
        });
        infowindow = new google.maps.InfoWindow();
        getCategories();
    }

    function addMarkerWithInfo(estabelecimento, map) {
        const address = `${estabelecimento.endereco.logradouro}, ${estabelecimento.endereco.numero}, ${estabelecimento.endereco.bairro}, ${estabelecimento.endereco.cidade}, ${estabelecimento.endereco.uf}`;
        console.log("Endereço para geocodificação:", address);

        if (address) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                address: address
            }, (results, status) => {
                if (status === 'OK') {
                    const marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: estabelecimento.name,
                    });
                    console.log("Marcador adicionado:", marker);

                    markers.push(marker);

                    const infowindow = new google.maps.InfoWindow({
                        content: `<div><strong>${estabelecimento.name}</strong><br>${estabelecimento.description}</div>`
                    });

                    console.log("InfoWindow criada:", infowindow);

                    marker.addListener('click', () => {
                        infowindow.open(map, marker); // Abre a janela de informações no contexto correto
                        console.log("Janela de informações aberta");
                        loadEstabelecimentoInfo(estabelecimento.id);
                    });

                    const listItem = document.createElement('li');
                    listItem.textContent = `Nome: ${estabelecimento.name}, Categoria: ${estabelecimento.category}`;

                    if (!addedEstabelecimentos.includes(estabelecimento.id)) {
                        listItem.addEventListener('click', () => {
                            loadEstabelecimentoInfo(estabelecimento.id);
                            console.log("Detalhes do estabelecimento carregados");
                            showEstabelecimentoInfo(`<div><strong>${estabelecimento.name}</strong><br>${estabelecimento.description}</div>`);
                        });
                        estabelecimentosList.appendChild(listItem);
                        addedEstabelecimentos.push(estabelecimento.id);
                    }
                } else {
                    console.error('Erro ao geocodificar endereço:', status);
                }
            });
        } else {
            console.error('Endereço não encontrado para o estabelecimento:', estabelecimento.name);
        }
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
        console.log("Função searchPlaces foi chamada");
        clearMarkers();

        estabelecimentosList.innerHTML = '';
        addedEstabelecimentos = [];

        const category = document.getElementById('category').value;
        const city = document.getElementById('city').value;

        if (category === 'all') {
            addAllMarkersAndList(city); // Passa a cidade como parâmetro
        } else {
            fetch(`/obter-estabelecimentos-por-categoria?category=${category}&city=${city}`)
                .then(response => response.json())
                .then(data => {
                    const estabelecimentos = data;
                    console.log("Estabelecimentos obtidos:", estabelecimentos);

                    estabelecimentos.forEach(estabelecimento => {
                        addMarkerWithInfo(estabelecimento, map);
                    });
                })
                .catch(error => {
                    console.error('Erro ao obter estabelecimentos por categoria:', error);
                });
        }
    }


    function addAllMarkersAndList(city) {
    console.log("Função addAllMarkersAndList foi chamada");
    estabelecimentosList.innerHTML = ''; // Limpar a lista de estabelecimentos antes de adicionar novos itens
    addedEstabelecimentos = [];
    fetch(`/obter-todos-estabelecimentos-ativos?city=${city}`)
        .then(response => response.json())
        .then(data => {
            const estabelecimentos = data;
            console.log("Estabelecimentos ativos obtidos:", estabelecimentos);

            estabelecimentos.forEach(estabelecimento => {
                const address = `${estabelecimento.endereco.logradouro}, ${estabelecimento.endereco.numero}, ${estabelecimento.endereco.bairro}, ${estabelecimento.endereco.cidade}, ${estabelecimento.endereco.uf}`;
                if (address) {
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        address: address
                    }, (results, status) => {
                        if (status === 'OK') {
                            const marker = new google.maps.Marker({
                                map: map,
                                position: results[0].geometry.location,
                                title: estabelecimento.name
                            });

                            markers.push(marker);

                            const listItem = document.createElement('li');
                            listItem.textContent = `Nome: ${estabelecimento.name}, Categoria: ${estabelecimento.category}`;
                            listItem.addEventListener('click', () => {
                                loadEstabelecimentoInfo(estabelecimento.id);
                            });
                            estabelecimentosList.appendChild(listItem);

                            // Exibir a janela de detalhes ao adicionar um marcador
                            const infoContent = `
                                <div>
                                    <strong>${estabelecimento.name}</strong><br>
                                    Categoria: ${estabelecimento.category}<br>
                                    Endereço: ${address}<br>
                                    <a href="${estabelecimento.link}" target="_blank">Saiba mais</a>
                                </div>
                            `;
                            const infowindow = new google.maps.InfoWindow({
                                content: infoContent
                            });

                            marker.addListener('click', () => {
                                infowindow.open(map, marker);
                            });
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
                // Exibir as informações do estabelecimento na janela de informações
                const estabelecimentoInfo = `Nome: ${data.name}, Descrição: ${data.description}, Endereço: ${data.endereco}`;
                showEstabelecimentoInfo(estabelecimentoInfo);
            })
            .catch(error => {
                console.error('Erro durante a solicitação do estabelecimento:', error);
            });
    }


    function showEstabelecimentoInfo(info) {
        if (infowindow) {
            infowindow.close(); // Fecha a janela de informações anterior, se estiver aberta
        }
        infowindow = new google.maps.InfoWindow({
            content: info
        });
        infowindow.open(map);
    }

    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe5MaIMdFA_uVpuz59EnVu5lMThHOv9Ek&callback=initMap"></script>
@endsection