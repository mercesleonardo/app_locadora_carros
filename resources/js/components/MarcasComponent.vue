<template>
    <div className="container">
        <div className="row justify-content-center">
            <div className="col-md-8">
                <!-- Inicío do card de busca -->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary float-sm-end">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->

                <!-- Início da lista de marcas -->
                <card-component titulo="Relação das marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>
                    <template v-slot:rodape>
                        <button type="button" class="btn btn-primary float-sm-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                    </template>
                </card-component>
                <!-- Fim do lista de marcas -->
            </div>
        </div>
        <modal-component id="modalMarca" titulo="Adicionar marca">
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus === 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus === 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo>
                <div class="form-group">
                    <div class="col mb-3">
                        <input-container-component titulo="Nome da marca" id="novoNome" id-help="novoNomeHelp" texto-ajuda="Informe o nome da marca">
                            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da marca" v-model="nomeMarca">
                        </input-container-component>
                        {{nomeMarca}}
                    </div>
                    <div class="col mb-3">
                        <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Imagem da marca">
                            <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" @change="carregarImagem($event)">
                        </input-container-component>
                        {{arquivoImagem}}
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
    </div>
</template>
<script>
export default {
    computed: {
        token() {
            let token = document.cookie.split(';').find(indice => {
                return indice.includes('token=')
            })

            token = token.split('=')[1]
            token = 'Bearer ' + token
            return token
        }
    },
    data() {
        return {
            urlBase: 'http://localhost:80/api/v1/marca',
            nomeMarca: '',
            arquivoImagem: null,
            transacaoStatus: '',
            transacaoDetalhes: {},
        }
    },
    methods: {
        carregarImagem(event) {
            this.arquivoImagem = event.target.files[0];
        },
        salvar: function () {

            let formData = new FormData();
            formData.append('nome', this.nomeMarca);
            formData.append('imagem', this.arquivoImagem);

            let config = {
                headers: {
                    'Content-Type':'multipart/form-data',
                    'Accept':'application/json',
                    'Authorization': this.token

                }
            }

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'Id do registro: ' + response.data.id
                    }
                    console.log(response);

                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem : errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                }
            );
        }
    }
}
</script>
