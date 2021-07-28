<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Importacao\Actions\CriarImportacao;
use App\Domains\Importacao\Models\Importacao;
use App\Packages\ArmazenamentoClient;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class ImportarArquivoCNAB
{
    function __construct(
        private ArmazenamentoClient $armazenamentoClient,
        private ProcessarArquivoCNAB $processarArquivoCnab,
        private CriarImportacao $criarImportacao
    )
    {
    }

    public function execute(string $operacaoUid, UploadedFile $arquivoCnab): Importacao
    {
//        $arquivoUid = $this->armazenamentoClient->uploadFile($arquivoCnab, true);
        $importacao = $this->criarImportacao->execute($operacaoUid, Str::uuid());

        $this->processarArquivoCnab
            ->onQueue('processamento-cnab')
            ->execute($importacao);

        return $importacao;
    }
}
