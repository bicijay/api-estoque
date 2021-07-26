<?php


namespace App\Domains\Titulo\Repositories;


use App\Domains\Titulo\DTO\TituloDTO;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Collection;
use MongoDB\Driver\WriteConcern;

class TitulosRepository
{
    /**
     * @param TituloDTO[] $tituloDTOS
     */
    public function insertMany(array $tituloDTOS)
    {
        foreach (array_chunk($tituloDTOS, 10000) as $chunk) {
            DB::connection('mongodb')->table('titulos')->raw(function (Collection $collection) use ($chunk) {
                $collection->insertMany($chunk, ["ordered" => false, "writeConcern" => new WriteConcern(0)]);
            });
        }
    }
}
