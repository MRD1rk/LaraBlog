<?php

namespace App\Services\Files;

use App\Services\Files\Interfaces\WriterInterface;
use App\Services\ParserService;
use File;

class CsvWriter implements WriterInterface
{
    private $filename = '';
    private $outputFilePath = '';
    private $fileExtension = '.csv';

    public function __construct()
    {
        $this->outputFilePath = ParserService::OUTPUT_FILES_PATH . '/csv';
    }
    public function write($data, $mode = 'w')
    {
        $newFile = $this->outputFilePath . DIRECTORY_SEPARATOR . $this->filename . '__' . time() . $this->fileExtension;
        $fp = fopen($newFile, $mode);
        foreach ($data as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
        return true;
    }

    public function setFilename($file)
    {
        $this->filename = pathinfo($file, PATHINFO_FILENAME);
        return $this;
    }

    public function concat($files) {
        $unionFile = 'union';
        $this->setFilename($unionFile);
        foreach ($files as $file) {
            $fullPath = $this->outputFilePath . '/'. $file;
            if ($this->write(array_map('str_getcsv', file($fullPath)), 'a')) {
                File::delete($fullPath);
            }
        }
        return true;
    }
}
