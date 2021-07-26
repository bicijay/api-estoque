<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Packages\ArmazenamentoClient;
use Illuminate\Support\Facades\Http;

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

        Http::withOptions([
            'sink' => $filePath
        ])->get("https://filetransfer.io/data-package/r1NZWYEk/download");

        return $filePath;
    }
}
