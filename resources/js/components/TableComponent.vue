<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th v-for="(t, key) in titulos" :key="key" scope="col" class="text-uppercase">{{ t }}</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="obj in dados" :key="obj.id">
                    <td v-for="t in titulos" :key="t">
                        <span v-if="t === 'imagem'">
                            <img :src="'/storage/'+obj[t]" alt="Imagem da marca" width="30" height="30">
                        </span>
                        <span v-else>
                            {{ obj[t] }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['dados', 'titulos']
    }
</script>
