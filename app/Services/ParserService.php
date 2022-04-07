<?php

namespace App\Services;

use App\Services\Files\Factories\WriterFactory;
use File;
use PHPSQLParser\PHPSQLParser;

class ParserService
{
    const SOURCE_FILES_PATH = 'uploads/sql_src';
    const OUTPUT_FILES_PATH = 'uploads/output';
    const SQL_INSERT = 'INSERT INTO ';
    const AVAILABLE_FORMATS = [
        'csv',
        'xml',
        'txt'
    ];
    const SQL_TABLE_NAMES = [
        'wp_posts',
        'wp1of20_posts'
    ];

    private $parser;

    public function __construct(PHPSQLParser $parser)
    {
        $this->parser = $parser;
        foreach (self::AVAILABLE_FORMATS as $format) {
            if (!File::exists(self::OUTPUT_FILES_PATH . '/' . $format)) {
                File::makeDirectory(self::OUTPUT_FILES_PATH . '/' . $format);
            }
        }
    }

    public function checkFileExist($fullPath)
    {
        return File::isFile($fullPath) && File::exists($fullPath);
    }
    public function getFilesFromDir($dirPath, $extension = 'sql'): array
    {
        $path = public_path($dirPath);
        $totalFiles = File::files($path);
        $files = array_filter($totalFiles, function ($file) use ($extension) {
            return $file->getExtension() == $extension;
        });
        return $files;
    }

    /**
     * Процесс парсинга переданных файлов баз данных
     * @param $files
     * @param $type
     * @return bool
     * @throws \Exception
     */
    public function parse($files, $type)
    {
        $result = [];
        foreach ($files as $file) {
            $filePath = self::SOURCE_FILES_PATH . DIRECTORY_SEPARATOR . $file;
            if (!File::isFile($filePath)) {
                throw new \Exception('Can\'t parse file: ' . basename($filePath));
            }
            $data = $this->parseProcess($filePath);
            $result[$file] = $data;
            WriterFactory::build($type)
                ->setFilename($file)
                ->write($data);
        }
        return true;
    }

    /**
     * Парсинг конкретного sql файла
     * @param $path
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function parseProcess($path)
    {
        $result = [];
        $lines = explode("\n", File::get($path));

        $lines = $this->filterLines($lines);
        $data = $this->parser->parse(implode("\n", $lines));
        $values = $data['VALUES'] ?? null;
        if ($values) {
            foreach ($values as  $value) {
                $result[] = [
                    'title' => html_entity_decode(trim($value['data'][5]['base_expr'], "'")),
                    'content' => html_entity_decode(trim($value['data'][4]['base_expr'], "'"))
                ];
            }
        }
        return $result;
    }


    /**
     * Функция, ищет нужные SQL запросы
     * @param $lines
     * @return array
     */
    public function filterLines($lines)
    {
        $result = [];
        $flag = false;
        for ($i = 0; $i < count($lines); $i++) {
            $line = $this->sanitize($lines[$i]);
            if (!$flag) {
                if (mb_strpos($line, self::SQL_INSERT) === 0// find INSERT QUERY
                    && $this->checkTableNames($line)) {
                    $flag = true;
                    $result[] = $line;
                }
            } else {
                $result[] = $line;
                if (mb_strpos($line, ');') !== false) {
                    $flag = false;
                }
            }
        }
        return $result;
    }

    /**
     * Функция проверяет "подходит" ли таблица
     * @param $line
     * @return bool
     */
    private function checkTableNames($line)
    {
        $result = false;
        foreach (self::SQL_TABLE_NAMES as $tableName) {
            if (!$result) {
                $result = mb_strpos($line, $tableName) !== false;
            }
        }
        return $result;
    }

    /**
     * Функция очищает от "мусорных" данных
     * @param $string
     * @return string
     */
    private function sanitize($string)
    {
        $virginString = $string;
        $virginString = preg_replace('/(^\s+)|(\s+$)/us', '', $virginString);
        $virginString = preg_replace('/\<a.*\>(.*)\<\/a\>/', '$1', $virginString);
        $virginString = preg_replace('/<img[^>]+\>/i', '', $virginString);
        $virginString = str_replace('`', '', $virginString);

        return trim($virginString);
    }

    public function union($files, $type) {
        return WriterFactory::build($type)->concat($files);
    }

}
