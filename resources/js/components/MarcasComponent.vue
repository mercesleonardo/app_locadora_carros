<template>
    <div className="container">
        <div className="row justify-content-center">
            <div className="col-md-8">
                <div className="card">
                    <div className="card-header">Busca de marcas</div>

                    <div className="card-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="inputId" class="form-label">ID</label>
                                <input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="ID">
                                <div id="idHelp" class="form-text">Opcional. Informe o ID do registro</div>
                            </div>
                            <div class="col mb-3">
                                <label for="nomeId" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nomeId" aria-describedby="nomeHelp" placeholder="Nome">
                                <div id="nomeHelp" class="form-text">Opcional. Informe o nome da marca</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-sm-end">Pesquisar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

</script>
