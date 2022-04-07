<?php

namespace App\Services\Files\Factories;

use App\Services\Files\CsvWriter;
use App\Services\Files\Interfaces\WriterInterface;
use App\Services\Files\TxtWriter;
use App\Services\Files\XmlWriter;

class WriterFactory
{
    public static function build($type):WriterInterface
    {
        switch ($type) {
            case 'xml':
                return new XmlWriter();
            case 'txt':
                return new TxtWriter();
            case 'csv':
                return new CsvWriter();
            default:
                throw new \Exception('Fail during creating Class by type:' . $type);
        }
    }
}
