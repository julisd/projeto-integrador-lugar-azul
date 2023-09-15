@extends('layout.app', ['current' => 'home'])

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Cadastro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('estabelecimento.atualizarConta') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="cnpj">CNPJ</label>
                            <input id="cnpj" type="text" class="form-control @error('cnpj') is-invalid @enderror" name="cnpj" value="{{ Auth::user()->cnpj }}" required>
                            @error('cnpj')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ Auth::user()->description }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Categoria</label>
                            <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                                <option value="" disabled selected>Selecione uma categoria</option>
                                <option value="Lazer" @if(Auth::user()->category == 'Lazer') selected @endif>Lazer</option>
                                <option value="Saúde" @if(Auth::user()->category == 'Saúde') selected @endif>Saúde</option>
                                <option value="Educação" @if(Auth::user()->category == 'Educação') selected @endif>Educação</option>
                            </select>
                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="cep" class="col-md-4 col-form-label text-md-end">{{ __('CEP') }}</label>
                            <div class="col-md-6">
                            <input id="cep" type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" value="{{ old('cep', optional($user->endereco)->cep) }}" required autocomplete="cep" maxlength="9">
                                @error('cep')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="logradouro" class="col-md-4 col-form-label text-md-end">{{ __('Logradouro') }}</label>
                            <div class="col-md-6">
                                <input id="logradouro" type="text" class="form-control @error('logradouro') is-invalid @enderror" name="logradouro" value="{{ old('logradouro', optional(Auth::user()->endereco)->logradouro) }}" required autocomplete="logradouro">
                                @error('logradouro')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="numero" class="col-md-4 col-form-label text-md-end">{{ __('Número') }}</label>
                            <div class="col-md-6">
                                <input id="numero" type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero', optional(Auth::user()->endereco)->numero) }}">
                                @error('numero')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="complemento" class="col-md-4 col-form-label text-md-end">{{ __('Complemento') }}</label>
                            <div class="col-md-6">
                                <input id="complemento" type="text" class="form-control" name="complemento" value="{{ old('complemento', optional(Auth::user()->endereco)->complemento) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="bairro" class="col-md-4 col-form-label text-md-end">{{ __('Bairro') }}</label>
                            <div class="col-md-6">
                                <input id="bairro" type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" value="{{ old('bairro', optional(Auth::user()->endereco)->bairro) }}" required autocomplete="bairro">
                                @error('bairro')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cidade" class="col-md-4 col-form-label text-md-end">{{ __('Cidade') }}</label>
                            <div class="col-md-6">
                                <input id="cidade" type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" value="{{ old('cidade', optional(Auth::user()->endereco)->cidade) }}" required autocomplete="cidade">
                                @error('cidade')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="uf" class="col-md-4 col-form-label text-md-end">{{ __('UF') }}</label>
                            <div class="col-md-6">
                                <select id="uf" class="form-control @error('uf') is-invalid @enderror" name="uf" required>
                                    <option value="" disabled selected>Selecione um estado</option>
                                    <option value="AC" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'AC' ? 'selected' : '' }}>Acre</option>
                                    <option value="AL" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'AL' ? 'selected' : '' }}>Alagoas</option>
                                    <option value="AP" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'AP' ? 'selected' : '' }}>Amapá</option>
                                    <option value="AM" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'AM' ? 'selected' : '' }}>Amazonas</option>
                                    <option value="BA" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'BA' ? 'selected' : '' }}>Bahia</option>
                                    <option value="CE" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'CE' ? 'selected' : '' }}>Ceará</option>
                                    <option value="DF" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                    <option value="ES" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                    <option value="GO" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'GO' ? 'selected' : '' }}>Goiás</option>
                                    <option value="MA" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'MA' ? 'selected' : '' }}>Maranhão</option>
                                    <option value="MT" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                    <option value="MS" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                    <option value="MG" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                    <option value="PA" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'PA' ? 'selected' : '' }}>Pará</option>
                                    <option value="PB" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'PB' ? 'selected' : '' }}>Paraíba</option>
                                    <option value="PR" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'PR' ? 'selected' : '' }}>Paraná</option>
                                    <option value="PE" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                    <option value="PI" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'PI' ? 'selected' : '' }}>Piauí</option>
                                    <option value="RJ" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                    <option value="RN" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                    <option value="RS" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                    <option value="RO" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'RO' ? 'selected' : '' }}>Rondônia</option>
                                    <option value="RR" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'RR' ? 'selected' : '' }}>Roraima</option>
                                    <option value="SC" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                    <option value="SP" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'SP' ? 'selected' : '' }}>São Paulo</option>
                                    <option value="SE" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'SE' ? 'selected' : '' }}>Sergipe</option>
                                    <option value="TO" {{ old('uf', optional(Auth::user()->endereco)->uf) === 'TO' ? 'selected' : '' }}>Tocantins</option>
                                </select>
                                @error('uf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Salvar Alterações') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#logradouro").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
        }

        //Quando o campo cep perde o foco.
        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#uf").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
    });
</script>
@endsection