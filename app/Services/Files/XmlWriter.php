<?php

namespace App\Services\Files;

use App\Services\Files\Interfaces\WriterInterface;
use App\Services\ParserService;
use DOMDocument;
use File;

class XmlWriter implements WriterInterface
{
    private $filename = '';
    private $outputFilePath = '';
    private $fileExtension = '.xml';

    public function __construct()
    {
        $this->outputFilePath = ParserService::OUTPUT_FILES_PATH . '/xml';
    }

    public function write($data)
    {
        $dom = $this->createXmlTemplate();
        $root = $dom->createElement('Posts');
        foreach ($data as $post) {
            $post_node = $dom->createElement('post');
            $child_node_title = $dom->createElement('Title', $post['title']);
            $post_node->appendChild($child_node_title);
            $child_node_content = $dom->createElement('Content', $post['content']);
            $post_node->appendChild($child_node_content);
            $root->appendChild($post_node);
            $dom->appendChild($root);
        }
        $this->saveFile($dom, $this->filename);
        return true;
    }

    public function saveFile($dom, $fileName)
    {
        $newFile = $this->outputFilePath . DIRECTORY_SEPARATOR . $fileName . '__' . time() . $this->fileExtension;
        $dom->save($newFile);
    }

    public function createXmlTemplate()
    {
        $dom = new DOMDocument();
        $dom->encoding = 'utf-8';
        $dom->xmlVersion = '1.0';

        $dom->formatOutput = true;
        return $dom;
    }

    public function setFilename($file)
    {
        $this->filename = pathinfo($file, PATHINFO_FILENAME);
        return $this;
    }

    public function concat($files)
    {
        $unionFile = 'union';
        $this->setFilename($unionFile);
        $dom = $this->createXmlTemplate();
        $root = $dom->createElement('Posts');
        foreach ($files as $file) {
            $fullPath = $this->outputFilePath . '/' . $file;
            $source = new DOMDocument();
            $source->load($fullPath);
            foreach ($source->documentElement->childNodes as $row) {
                $import = $dom->importNode($row, true);
                $root->appendChild($import);
            }
        }
        $dom->appendChild($root);
        $this->saveFile($dom, $this->filename);
        return true;
    }
}
