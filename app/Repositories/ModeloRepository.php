<?php

namespace App\Repositories;

use App\Models\Modelo;

class ModeloRepository extends AbstractRepository {
    public function __construct(Modelo $model)
    {
        parent::__construct($model);
    }
}
