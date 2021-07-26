<?php


namespace App\Domains\Importacao\Actions;


use App\Domains\Importacao\Models\Importacao;
use Illuminate\Support\Str;

class CriarImportacao
{
    public function execute(string $operacaoUid, string $arquivoUid): Importacao
    {
        return Importacao::create([
            "importacao_uid" => Str::uuid(),
            "operacao_uid" => $operacaoUid,
            "arquivo_uid" => $arquivoUid,
            "status" => "importacao_criada"
        ]);
    }
}
