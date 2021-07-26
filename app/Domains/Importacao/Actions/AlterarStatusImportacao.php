<?php


namespace App\Domains\Importacao\Actions;


use App\Domains\Importacao\Models\Importacao;
use Spatie\QueueableAction\QueueableAction;

class AlterarStatusImportacao
{
    use QueueableAction;

    public function execute(string $importacao_uid, string $novoStatus, string $statusDescricao = null): bool
    {
        $importacao = Importacao::find($importacao_uid);

        if ($novoStatus === "inicio_importacao") {
            $importacao->inicio_em = now();
            $importacao->fim_em = null;
        }

        if (in_array($novoStatus, ["erro_importacao", "sucesso_importacao"])) {
            $importacao->fim_em = now();
        }

        $importacao->status = $novoStatus;
        $importacao->status_descricao = $statusDescricao;
        $importacao->save();

        return true;
    }
}
