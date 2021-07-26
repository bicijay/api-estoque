<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Packages\ArmazenamentoClient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BaixarArquivoCnab
{
    function __construct(private ArmazenamentoClient $armazenamentoClient)
    {
    }

    public function execute(string $arquivoUid): string
    {
        $dirPath = storage_path("app/armazenamento");
        $filePath = $dirPath . "/{$arquivoUid}";

        if (!is_dir($dirPath)) {
            mkdir($dirPath);
        }

        Log::info("Começou download do arquivo");
        Http::withOptions([
            'sink' => $filePath
        ])->get("https://filetransfer.io/data-package/r1NZWYEk/download");
        Log::info("Terminou download do arquivo");

        return $filePath;
    }
}
