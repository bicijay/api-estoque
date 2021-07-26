<?php


namespace App\Domains\Titulo\DTO;


class TituloDTO
{
    public function __construct(
        public ?string $banco = null,
        public ?float $taxa_cessao = null,
        public ?float $valor_titulo = null,
        public ?float $valor_presente = null,
        public ?string $conteudo = null,
    )
    {
    }
}
