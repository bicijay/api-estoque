<?php


namespace App\Http\Controllers;


use App\Domains\Importacao\Actions\ImportacaoCNAB\ImportarArquivoCNAB;
use App\Http\Requests\ImportCNABRequest;
use Illuminate\Http\JsonResponse;

class ImportacaoCNABController extends Controller
{
    public function import(ImportCNABRequest $request, ImportarArquivoCNAB $importarArquivoCnab): JsonResponse
    {
        $arquivoCnab = $request->file('cnab_file');
        $operacaoUid = $request->input('operacao_uid');

        $importarArquivoCnab->execute($operacaoUid, $arquivoCnab);
        return response()->json(__("Importação do arquivo foi iniciada"));
    }
}
