<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicío do card de busca -->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp" texto-ajuda="Opcional. Informe o ID da marca">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID" v-model="busca.id">
                                </input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component titulo="Nome da marca" id="inputNome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o nome da marca">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca" v-model="busca.nome">
                                </input-container-component>
                            </div>
                        </div>
                    </template>
                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary float-sm-end" @click="pesquisar()">Pesquisar</button>
                    </template>
                </card-component>
                <!-- Fim do card de busca -->

                <!-- Início da lista de marcas -->
                <card-component titulo="Relação das marcas">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="marcas.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalVisualizacao'}"
                            :editar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalEditar'}"
                            :excluir="{visivel: true, dataToggle: 'modal', dataTarget: '#modalExcluir'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'}
                            }">

                        </table-component>
                    </template>
                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <paginate-component>
                                    <li v-for="(l, key) in marcas.links" :key="key" :class="['page-item', { active: l.active }]" @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
                            <div class="col-2">
                                <button type="button" class="btn btn-primary float-sm-end" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!-- Fim do lista de marcas -->
            </div>
        </div>

        <!-- Início do modal de inclusão de marca -->
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
                    </div>
                    <div class="col mb-3">
                        <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp" texto-ajuda="Imagem da marca">
                            <input type="file" class="form-control-file" id="novoImagem" aria-describedby="novoImagemHelp" @change="carregarImagem($event)">
                        </input-container-component>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
            </template>
        </modal-component>
        <!-- Fim do modal de inclusão de marca -->

        <!-- Início do modal de visualizaçao de marca -->
        <modal-component id="modalVisualizacao" titulo="Visualizar marca">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <!-- Verifica se 'item' está definido -->
                <div v-if="item">
                    <div class="row">
                        <div class="col-md-6">
                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" readonly :value="item.id">
                            </input-container-component>
                        </div>
                        <div class="col-md-6">
                            <input-container-component titulo="Nome da marca">
                                <input type="text" class="form-control" readonly :value="item.nome">
                            </input-container-component>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <input-container-component titulo="Imagem">
                                <div v-if="item.imagem">
                                    <img :src="'storage/' + item.imagem" alt="Imagem da marca" class="img-fluid">
                                </div>
                                <div v-else>
                                    <p>Imagem não disponível</p>
                                </div>
                            </input-container-component>
                        </div>
                        <div class="col-md-6">
                            <input-container-component titulo="Data de criação">
                                <input type="text" class="form-control" readonly :value="formatDate(item.created_at)">
                            </input-container-component>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!-- Fim do modal de visualizaçao de marca -->

        <!-- Início do modal de edição de marca -->
        <modal-component id="modalEditar" titulo="Editar marca">
            <template v-slot:alertas>

            </template>
            <template v-slot:conteudo>
                <div v-if="item">
                    <div class="form-group">
                        <div class="col mb-3">
                            <input-container-component titulo="Nome da marca" id="editarNome" id-help="editarNomeHelp" texto-ajuda="Informe o nome da marca">
                                <input type="text" class="form-control" id="editarNome" aria-describedby="editarNomeHelp" placeholder="Nome da marca" v-model="item.nome">
                            </input-container-component>
                        </div>
                        <div class="col mb-3">
                            <input-container-component titulo="Imagem" id="editarImagem" id-help="editarImagemHelp" texto-ajuda="Imagem da marca">
                                <input type="file" class="form-control-file" id="editarImagem" aria-describedby="editarImagemHelp" @change="carregarImagem($event)">
                            </input-container-component>
                        </div>
                    </div>
                </div>

                {{item}}
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="editar()">Editar</button>
            </template>
        </modal-component>
        <!-- Fim do modal de edição de marca -->

        <!-- Início do modal de remoção de marca -->
        <modal-component id="modalExcluir" titulo="Remover marca">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="transacao" v-if="transacao.status === 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="transacao" v-if="transacao.status === 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="transacao.status !== 'sucesso'">
                <!-- Verifica se 'item' está definido -->
                <div v-if="item">
                    <div class="row">
                        <div class="col-md-6">
                            <input-container-component titulo="ID">
                                <input type="text" class="form-control" readonly :value="item.id">
                            </input-container-component>
                        </div>
                        <div class="col-md-6">
                            <input-container-component titulo="Nome da marca">
                                <input type="text" class="form-control" readonly :value="item.nome">
                            </input-container-component>
                        </div>
                    </div>
                </div>
            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="excluir()" v-if="transacao.status !== 'sucesso'">Excluir</button>
            </template>
        </modal-component>
        <!-- Fim do modal de remoção de marca -->

    </div>
</template>
<script>
import { mapState, mapMutations } from 'vuex';
export default {
    computed: {
        ...mapState({
            item: state => state.item,
            transacao: state => state.transacao
        }),
        token() {
            let token = document.cookie.split(';').find(indice => indice.includes('token='));

            if (!token) {
                console.error('Token não encontrado');
                return null;
            }

            return 'Bearer ' + token.split('=')[1];
        }
    },
    data() {
        return {
            urlBase: 'http://localhost:80/api/v1/marca',
            nomeMarca: '',
            arquivoImagem: null,
            transacaoStatus: '',
            transacaoDetalhes: {},
            marcas: {data: []},
            busca: {
                id: '',
                nome: ''
            },
            urlPaginacao: '',
            urlFiltro: '',
            erro: '',
        }
    },
    methods: {
        salvar: function () {
            let formData = new FormData();
            formData.append('nome', this.nomeMarca);
            formData.append('imagem', this.arquivoImagem);

            const config = {
                headers: {
                    'Content-Type':'multipart/form-data',
                    'Accept':'application/json',
                    'Authorization': this.token

                }
            };

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: `Id do registro: ${response.data.id}`
                    };

                    this.carregarLista();

                    setTimeout(() => {
                        this.resetForm();
                    }, 3000);
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        dados: errors.response.data.errors
                    };
                });
        },
        editar() {
            let formData = new FormData();
            formData.append('_method', 'patch');
            formData.append('nome', this.item.nome);
            if (this.arquivoImagem) {
                formData.append('imagem', this.arquivoImagem);
            }

            const config = {
                headers: {
                    'Content-Type':'multipart/form-data',
                    'Accept':'application/json',
                    'Authorization': this.token

                }
            };

            const url = `${this.urlBase}/${this.item.id}`;

            axios.post(url, formData, config)
                 .then(response => {
                     console.log('Atualizado', response)
                     this.carregarLista();
                 })
                .catch(error => {
                    console.error('Erro ao atualizar', error.response)
                 });

        },
        excluir() {
            if (!this.item) {
                this.erro = 'Nenhum item selecionado para exclusão.';
                return;
            }

            let confirmacao = confirm('Tem certeza que deseja remover esse registro?');
            if (!confirmacao) return;

            const url = `${this.urlBase}/${this.item.id}`;
            const config = {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            };

            axios.delete(url, config)
                .then(response => {
                    this.transacao.status = 'sucesso';
                    this.transacao.mensagem = response.data.message;
                    this.carregarLista();
                })
                .catch(error => {
                    this.transacao.status = 'erro';
                    this.transacao.mensagem = 'Não foi possível deletar a marca';
                })
        },
        pesquisar() {
            let filtro = ''

            for (let chave in this.busca) {
                if (this.busca[chave]) {
                    if (filtro !== '') {
                        filtro += ';';
                    }
                    filtro += `${chave}:like:${this.busca[chave]}`;
                }
            }

            this.urlFiltro = filtro ? `&filtro=${filtro}` : '';
            this.urlPaginacao = 'page=1';
            this.carregarLista();
        },
        paginacao(l) {
            if (l.url) {
                this.urlPaginacao = l.url.split('?')[1];
                this.carregarLista();
            }
        },
        formatDate(date) {
            if (!date) return 'Data não disponível';
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('pt-BR', options);
        },
        carregarLista() {
            const url = `${this.urlBase}?${this.urlPaginacao}${this.urlFiltro}`;
            const config = {
                headers: {
                    'Accept':'application/json',
                    'Authorization': this.token
                }
            };

            axios.get(url, config)
                .then(response => {
                    this.marcas = response.data;
                })
                .catch(error => {
                    this.erro = 'Erro ao carregar a lista de marcas.';
                    console.log(error);
                })

        },
        carregarImagem(event) {
            this.arquivoImagem = event.target.files[0];
        },
        resetForm() {
            this.nomeMarca = '';
            this.arquivoImagem = null;
            this.transacaoStatus = '';
            this.transacaoDetalhes = {};
        }
    },
    mounted() {
        this.carregarLista();
    }
}
</script>
