<template>
    <div :class="estilo" role="alert">
        A simple success alert—check it out!
        {{tipo}}
    </div>
</template>

<script>
    export default {
        props: ['tipo'],
        computed: {
            estilo() {
                return 'alert alert-'+this.tipo
            }
        }
    }
</script>
