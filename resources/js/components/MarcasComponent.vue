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
                <alert-component tipo="success"></alert-component>
                <alert-component tipo="danger"></alert-component>
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
                arquivoImagem: []
            }
        },
        methods: {
            carregarImagem(event) {
                this.arquivoImagem = event.target.files;
            },
            salvar: function () {

                let formData = new FormData();
                formData.append('nome', this.nomeMarca);
                formData.append('imagem', this.arquivoImagem[0]);

                let config = {
                    headers: {
                        'Content-Type':'multipart/form-data',
                        'Accept':'application/json',
                        'Authorization': this.token

                    }
                }

                axios.post(this.urlBase, formData, config)
                .then(response => {
                    console.log(response);
                    // this.nomeMarca = '';
                    // this.arquivoImagem = [];
                    // Swal.fire('Marca salva com sucesso!');

                })
                .catch(errors => {
                    console.log(errors);
                    // Swal.fire('Ocorreu um erro ao salvar a marca!');
                });
            }
        }
    }
</script>
