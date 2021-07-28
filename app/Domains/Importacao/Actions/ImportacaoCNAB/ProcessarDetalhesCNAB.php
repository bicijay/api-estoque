<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Importacao\Actions\AlterarStatusImportacao;
use App\Domains\Importacao\DTOs\DadosProcessamentoCNAB;
use App\Domains\Importacao\Parsers\CnabFileParser;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Spatie\QueueableAction\ActionJob;
use Spatie\QueueableAction\QueueableAction;

class ProcessarDetalhesCNAB
{
    use QueueableAction;

    function __construct(
        private AlterarStatusImportacao $alterarStatusImportacao,
        private CnabFileParser $cnabFileParser
    )
    {
    }

    public function execute(DadosProcessamentoCNAB $dadosProcessamentoCNAB)
    {
        $jobs = [];

        $this->cnabFileParser->getDetalhesChunks($dadosProcessamentoCNAB->caminhoArquivoCnab, config("processamento.max_detalhes_chunk"), function ($detalhes) use ($jobs) {
            $jobs[] = new ActionJob(ProcessarLinhasDetalhesCnab::class, [$detalhes]);
        });

        $batch = Bus::batch($jobs)
            ->onQueue('processamento-cnab')
            ->then(function (Batch $batch) use ($dadosProcessamentoCNAB) {
                $this->alterarStatusImportacao->execute($dadosProcessamentoCNAB->importacao->importacao_uid, "sucesso_importacao");
            })->catch(function (Batch $batch, \Throwable $e) use ($dadosProcessamentoCNAB) {
                $this->alterarStatusImportacao->execute($dadosProcessamentoCNAB->importacao->importacao_uid, "erro_importacao", $e->getMessage());
            })->dispatch();
    }
}
