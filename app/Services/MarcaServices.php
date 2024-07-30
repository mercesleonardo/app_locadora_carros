<?php

namespace App\Services;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\MarcaUpdateRequest;
use App\Models\Marca;
use Illuminate\Support\Str;

class MarcaServices
{
    public function lista()
    {
        return Marca::paginate(10);
    }

    public function store(MarcaStoreRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nome']);

        return Marca::create($data);
    }

    public function update(MarcaUpdateRequest $request, Marca $marca)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nome']);
        $marca->update($data);

        return $marca;
    }

    public function destroy(Marca $marca)
    {
        $marca->delete();
    }
}
