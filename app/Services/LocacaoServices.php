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
        try {
//            if ($request->has('atributos_modelos')) {
//                $atributos_modelos = 'modelo:id,' . $request->atributos_modelos;
//                $this->locacaoRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
//            } else {
//                $this->locacaoRepository->selectAtributosRegistrosRelacionados('modelo');
//            }

            if ($request->has('filtro')) {
                $this->locacaoRepository->filtro($request->filtro);
            }

            if ($request->has('atributos')) {
                $this->locacaoRepository->selectAtributos($request->atributos);
            }

            return $this->locacaoRepository->getResultado()->paginate(10);
        } catch (Exception $e) {
            Log::error('Erro ao listar locacaos: ' . $e->getMessage());
            throw new Exception('Erro ao listar locacaos');
        }
    }

    public function store(LocacaoStoreRequest $request)
    {
        try {
            return Locacao::create($request->validated());
        } catch (Exception $e) {
            Log::error('Erro ao criar locacao: ' . $e->getMessage());
            throw new Exception('Erro ao criar locacao');
        }
    }

    public function update(LocacaoUpdateRequest $request, Locacao $locacao)
    {
        try {
            $locacao->update($request->validated());
            return $locacao;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar locacao: ' . $e->getMessage());
            throw new Exception('Erro ao atualizar locacao');
        }
    }

    public function destroy(Locacao $locacao)
    {
        try {
            $locacao->delete();
        } catch (Exception $e) {
            Log::error('Erro ao deletar locacao: ' . $e->getMessage());
            throw new Exception('Erro ao deletar locacao');
        }
    }
}
