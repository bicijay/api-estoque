<?php


namespace App\Domains\Importacao\DTOs;


use App\Domains\Importacao\Models\Importacao;

class DadosProcessamentoCNAB
{
    public function __construct(
        public ?Importacao $importacao = null,
        public ?array $operacao = null,
        public ?float $taxaCessao = null,
        public ?array $layoutsDaOperacao = null,
        public ?string $caminhoArquivoCnab = null
    )
    {
    }
}
