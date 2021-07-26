<?php


namespace App\Domains\Importacao\Parsers;

use App\Packages\LargeFile;

class CnabFileParser
{
    function __construct(private LargeFile $largeFile,)
    {
    }

    public function getHeaderLine($cnabPath): string
    {
        return $this->largeFile->firstLine($cnabPath);
    }

    public function getTrailerLine(string $cnabPath): string
    {
        return $this->largeFile->lastLines($cnabPath, 1);
    }

    public function getDetalhesChunks(string $cnabPath, int $detalhesPerChunk, \Closure $callback)
    {
        $this->largeFile->chunkLines($cnabPath, $detalhesPerChunk, function ($lines) use ($callback) {
            $callback($lines);
        });
    }
}
