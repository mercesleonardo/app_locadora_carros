<?php

namespace App\Services;

use App\Http\Requests\LocacaoStoreRequest;
use App\Http\Requests\LocacaoUpdateRequest;
use App\Models\Locacao;
use App\Repositories\LocacaoRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocacaoServices
{
    public function __construct(protected LocacaoRepository $locacaoRepository)
    {
    }
    public function lista(Request $request)
    {
        if ($request->has('filtro')) {
            $this->locacaoRepository->filtro($request->filtro);
        }

        if ($request->has('atributos')) {
            $this->locacaoRepository->selectAtributos($request->atributos);
        }

        return $this->locacaoRepository->getResultado()->paginate(10);
    }

    public function store(LocacaoStoreRequest $request)
    {
        return Locacao::create($request->validated());
    }

    public function update(LocacaoUpdateRequest $request, Locacao $locacao)
    {
        $locacao->update($request->validated());
        return $locacao;
    }

    public function destroy(Locacao $locacao)
    {
        $locacao->delete();
    }
}
