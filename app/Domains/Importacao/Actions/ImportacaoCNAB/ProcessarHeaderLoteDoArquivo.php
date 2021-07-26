<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Importacao\DTOs\DadosProcessamentoCNAB;
use App\Domains\Importacao\Parsers\CnabFileParser;

class ProcessarHeaderLoteDoArquivo
{
    function __construct(private CnabFileParser $cnabFileParser)
    {
    }

    public function execute(DadosProcessamentoCNAB $dadosProcessamentoCNAB)
    {
        $header = $this->cnabFileParser->getHeaderLine($dadosProcessamentoCNAB->caminhoArquivoCnab);
        $trailer = $this->cnabFileParser->getTrailerLine($dadosProcessamentoCNAB->caminhoArquivoCnab);

        //TODO PEGAR INFORMACOES DA LINHA E VALIDAR ARQUIVO
    }
}
