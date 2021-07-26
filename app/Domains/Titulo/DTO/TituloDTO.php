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

    public function toArray(): array
    {
        return [
            "banco" => $this->banco,
            "taxa_cessao" => $this->taxa_cessao,
            "valor_titulo" => $this->valor_titulo,
            "valor_presente" => $this->valor_presente,
            "conteudo" => $this->conteudo
        ];
    }
}
