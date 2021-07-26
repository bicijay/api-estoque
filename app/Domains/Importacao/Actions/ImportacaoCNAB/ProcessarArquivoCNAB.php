<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Importacao\Actions\AlterarStatusImportacao;
use App\Domains\Importacao\DTOs\DadosProcessamentoCNAB;
use App\Domains\Importacao\Models\Importacao;
use App\Domains\Titulo\Actions\DeletarTitulosImportados;
use App\Packages\CnabClient;
use App\Packages\OperacaoClient;
use Spatie\QueueableAction\QueueableAction;

class ProcessarArquivoCNAB
{
    use QueueableAction;

    function __construct(
        private AlterarStatusImportacao $alterarStatusImportacao,
        private DeletarTitulosImportados $deletarTitulosImportados,
        private ProcessarHeaderLoteDoArquivo $processarHeaderLoteCnab,
        private ProcessarDetalhesCNAB $processarDetalhesCNAB,
        private BaixarArquivoCnab $baixarArquivoCnab,
        private OperacaoClient $operacaoClient,
        private CnabClient $cnabClient
    )
    {
    }

    public function execute(Importacao $importacao)
    {
        try {
            $this->alterarStatusImportacao->execute($importacao->importacao_uid, "inicio_importacao");

            $operacao = $this->operacaoClient->getOperacao($importacao->operacao_uid);
            $taxaCessao = $this->operacaoClient->getOperacaoTaxaDeCessao($importacao->operacao_uid);
            $operacaoLayouts = $this->cnabClient->getOperationLayouts($importacao->operacao_uid);
            $caminhoArquivoCnab = $this->baixarArquivoCnab->execute($importacao->arquivo_uid);

            $dadosParaProcessamento = new DadosProcessamentoCNAB($importacao, $operacao, $taxaCessao, $operacaoLayouts, $caminhoArquivoCnab);
            $this->deletarTitulosImportados->execute($importacao->importacao_uid);
            $this->processarHeaderLoteCnab->execute($dadosParaProcessamento);
            $this->processarDetalhesCNAB->execute($dadosParaProcessamento);

        } catch (\Throwable $e) {
            $this->alterarStatusImportacao->execute($importacao->importacao_uid, "erro_importacao", $e->getMessage());
        }
    }
}
