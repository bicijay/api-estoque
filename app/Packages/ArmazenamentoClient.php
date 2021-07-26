<?php


namespace App\Packages;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArmazenamentoClient
{
    public function uploadFile(UploadedFile $file, bool $bloquearHashDuplicada = false): string
    {
        $arquivoUid = Str::uuid();
        sha1($file->get());

        $file->store(storage_path("armazenamento/{$arquivoUid}"));
        return $arquivoUid;
    }

    public function getFile(string $arquivoUid): string
    {
        return Storage::get("armazenamento/{$arquivoUid}");
    }
}
