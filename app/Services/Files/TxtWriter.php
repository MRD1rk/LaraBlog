<?php

namespace App\Services\Files;

use App\Services\Files\Interfaces\WriterInterface;
use App\Services\ParserService;
use File;

class TxtWriter implements WriterInterface
{
    private $filename = '';
    private $outputFilePath = '';
    private $fileExtension = '.txt';

    public function __construct()
    {
        $this->outputFilePath = ParserService::OUTPUT_FILES_PATH . '/txt';
    }

    public function write($data)
    {
        $newData = [];
        if (is_array($data)) {
            foreach ($data as $datum) {
                $newData[] = $datum['title'] . ' ' . $datum['content'] . PHP_EOL;
            }
            $newData = implode("\n", $newData);
        } else {
            $newData = $data;
        }
        $newFile = $this->outputFilePath . DIRECTORY_SEPARATOR . $this->filename . '__' . time() . $this->fileExtension;

        return file_put_contents($newFile, $newData, FILE_APPEND) > 0;
    }

    public function setFilename($file)
    {
        $this->filename = $file;
        return $this;
    }

    public function concat($files)
    {
        $unionFile = 'union';
        $this->setFilename($unionFile);
        foreach ($files as $file) {
            $fullPath = $this->outputFilePath . '/' . $file;
            if ($this->write(file_get_contents($fullPath))) {
                File::delete($fullPath);
            }
        }
        return true;
    }
}
