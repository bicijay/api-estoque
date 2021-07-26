<?php


namespace App\Domains\Importacao\Models;


use Illuminate\Database\Eloquent\Model;

class Importacao extends Model
{
    protected $table = "importacoes";

    protected $primaryKey = "importacao_uid";
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'importacao_uid',
        'operacao_uid',
        'arquivo_uid',
        'status',
        'inicio_em',
        'fim_em'
    ];
}
