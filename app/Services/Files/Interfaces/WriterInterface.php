<?php

namespace App\Services\Files\Interfaces;

interface WriterInterface
{
    public function write($data);

    public function concat($files);

    public function setFilename($filename);
}
