<template>
    <div className="card mb-3">
        <div className="card-header">{{titulo}}</div>

        <div className="card-body">
            <slot name="conteudo"></slot>
        </div>
        <div class="card-footer">
            <slot name="rodape"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['titulo']
    }
</script>
