<?php

namespace App\Services;

use App\Http\Requests\MarcaStoreRequest;
use App\Http\Requests\MarcaUpdateRequest;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarcaServices
{
    public function lista()
    {
        return Marca::with('modelos')->paginate(10);
    }

    public function store(MarcaStoreRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['nome']);

        $path = $request->file('imagem')->store('imagens', 'public');
        $data['imagem'] = $path;

        return Marca::create($data);
    }

    public function update(MarcaUpdateRequest $request, Marca $marca)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['nome']);

        if ($request->hasFile('imagem')) {

            if ($marca->imagem) {
                Storage::disk('public')->delete($marca->imagem);
            }

            $path = $request->file('imagem')->store('imagens', 'public');
            $data['imagem'] = $path;
        }

        $marca->update($data);

        return $marca;
    }

    public function destroy(Marca $marca)
    {
        if ($marca->imagem) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $marca->delete();
    }
}
