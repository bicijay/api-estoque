<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Importacao\DTOs\DadosProcessamentoCNAB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;

class ProcessarLinhasDetalhesCnab
{
    use QueueableAction;

    public function execute(array $detalhes)
    {
        $dataInsert = [];

        foreach ($detalhes as $detalhe) {
            $dataInsert[] = [
                "banco" => substr($detalhe, 0, 3),
                "conteudo" => $detalhe
            ];
        }

        DB::table("titulos")->insert($dataInsert);
    }
}
