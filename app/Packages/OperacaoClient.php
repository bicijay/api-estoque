<?php


namespace App\Packages;


class OperacaoClient
{
    public function getOperacao(string $operacaoUid): array
    {
        return [
            "operacao_uid" => $operacaoUid,
            "nome" => "Operacao Teste"
        ];
    }

    public function getOperacaoTaxaDeCessao(string $operacao_uid): float
    {
        return 1.50;
    }
}
