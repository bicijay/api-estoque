<?php


namespace App\Domains\Importacao\Actions\ImportacaoCNAB;


use App\Domains\Titulo\DTO\TituloDTO;

use App\Domains\Titulo\Repositories\TitulosRepository;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Collection;
use MongoDB\Driver\WriteConcern;
use Spatie\QueueableAction\QueueableAction;

class ProcessarLinhasDetalhesCnab
{
    use QueueableAction;

    function __construct(private TitulosRepository $titulosRepository)
    {
    }

    public function execute(array $detalhes)
    {
        $titulos = [];

        foreach ($detalhes as $detalhe) {
            $titulo = new TituloDTO();

            $titulo->banco = substr($detalhe, 0, 3);
            $titulo->valor_titulo = 200;
            $titulo->taxa_cessao = 1.50;
            $titulo->valor_presente = $titulo->valor_titulo * pow(1 + ($titulo->taxa_cessao / 100), 35 / 252);
            $titulo->conteudo = $detalhe;

            $titulos[] = $titulo;
        }

        $this->titulosRepository->insertMany($titulos);
    }
}
