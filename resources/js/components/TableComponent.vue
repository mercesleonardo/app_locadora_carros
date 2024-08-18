<template>
    <div>
        <table class="table table-hover ">
            <thead class="table-light">
                <tr>
                    <th v-for="(t, key) in titulos" :key="key" scope="col" class="text-center">{{ t.titulo }}</th>
                    <th v-if="visualizar.visivel || editar || excluir" class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody>
            <tr v-for="(obj, chave) in dadosFiltrados" :key="chave" class="align-middle">
                <td v-for="(valor, chaveValor) in obj" :key="chaveValor" class="text-center">
                    <span v-if="titulos[chaveValor].tipo === 'texto'">{{valor}}</span>
                    <span v-if="titulos[chaveValor].tipo === 'data'">{{ new Date(valor).toLocaleDateString() }}</span>
                    <span v-if="titulos[chaveValor].tipo === 'imagem'">
                        <img :src="'/storage/'+valor" alt="Imagem da marca" class="img-fluid" style="max-width: 40px; max-height: 40px;">
                    </span>
                </td>
                <td v-if="visualizar.visivel || editar || excluir" class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button v-if="visualizar.visivel" type="button" class="btn btn-outline-primary btn-sm" :data-bs-toggle="visualizar.dataToggle" :data-bs-target="visualizar.dataTarget">Visualizar</button>
                        <button v-if="editar" type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar">Editar</button>
                        <button v-if="excluir" type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalExcluir">Excluir</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos', 'visualizar', 'editar', 'excluir'],
        computed: {
            dadosFiltrados() {
                let campos = Object.keys(this.titulos)
                let dadosFiltrados = []

                this.dados.map((item, chave) => {

                    let itemFiltrado = {}
                    campos.forEach(campo => {
                        itemFiltrado[campo] = item[campo]
                    })
                    dadosFiltrados.push(itemFiltrado)
                })
                return dadosFiltrados
            }
        }
    }
</script>
