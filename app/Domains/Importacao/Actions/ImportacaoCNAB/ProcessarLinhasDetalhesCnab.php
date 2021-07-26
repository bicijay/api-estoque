<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Importacao\DTOs\DadosProcessamentoCNAB;
use App\Domains\Titulo\DTO\TituloDTO;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

class ProcessarLinhasDetalhesCnab
{
    use QueueableAction;

    public function execute(array $detalhes)
    {
        $titulos = [];

        foreach ($detalhes as $detalhe) {
            $titulo = new TituloDTO();

            $titulo->banco = substr($detalhe, 0, 3);
            $titulo->valor_titulo = 200;
            $titulo->taxa_cessao = 1.50;
            $titulo->valor_presente = $this->calcVp($titulo);
            $titulo->conteudo = $detalhe;

            $titulos[] = $titulo->toArray();
        }

        foreach(array_chunk($titulos, 5000) as $chunk) {
            DB::table("titulos")->insert($chunk);
        }
    }

    private function calcVp(TituloDTO $tituloDTO): float
    {
        return $tituloDTO->valor_titulo * pow(1 + ($tituloDTO->taxa_cessao / 100), 35 / 252);
    }
}
