<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Importacao\Actions\AlterarStatusImportacao;
use App\Domains\Importacao\DTOs\DadosProcessamentoCNAB;
use App\Domains\Importacao\Models\Importacao;
use App\Domains\Importacao\Parsers\CnabFileParser;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
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
        $detalhesPerChunk = config("processamento.max_detalhes_chunk");
        $caminhoCnab = $dadosProcessamentoCNAB->caminhoArquivoCnab;

        $batch = Bus::batch([])
            ->onQueue('processamento-cnab')
            ->then(function (Batch $batch) use ($dadosProcessamentoCNAB) {
                $this->alterarStatusImportacao->execute($dadosProcessamentoCNAB->importacao->importacao_uid, "sucesso_importacao");
            })->catch(function (Batch $batch, \Throwable $e) use ($dadosProcessamentoCNAB) {
                $this->alterarStatusImportacao->execute($dadosProcessamentoCNAB->importacao->importacao_uid, "erro_importacao", $e->getMessage());
            })->dispatch();

        $this->cnabFileParser->getDetalhesChunks($caminhoCnab, $detalhesPerChunk, function ($detalhes) use ($batch) {
            $batch->add([new ActionJob(ProcessarLinhasDetalhesCnab::class, [$detalhes])]);
        });

    }
}
