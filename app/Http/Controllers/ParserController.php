<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParserParseRequest;
use App\Http\Requests\ParserUnionRequest;
use App\Services\ParserService;
use File;
use PHPSQLParser\PHPSQLParser;

class ParserController extends Controller
{
    /**
     * @var ParserService
     */
    private $fileService;

    public function __construct(ParserService $service)
    {
        $this->fileService = $service;
    }

    public function index()
    {
        $files = $this->fileService->getFilesFromDir($this->fileService::SOURCE_FILES_PATH);
        $availableFormats = $this->fileService::AVAILABLE_FORMATS;

        return view('parser.index', compact('files', 'availableFormats'));
    }

    public function parse(ParserParseRequest $request)
    {
        $files = $request->input('selected');
        $format = $request->input('format');
        if (!$files) {
            return back()->withErrors('Choose any db file');
        }
        if ($this->fileService->parse($files, $format)) {
            return redirect()
                ->route('parser.parsed', ['type' => $format]);
        }
    }

    public function parsed($type)
    {
        $availableFormats = $this->fileService::AVAILABLE_FORMATS;
        $files = $this->fileService->getFilesFromDir($this->fileService::OUTPUT_FILES_PATH . '/' . $type, $type);
        return view('parser.parsed', compact('files', 'availableFormats', 'type'));
    }

    public function download($type, $filename)
    {
        $fullPath = $this->fileService::OUTPUT_FILES_PATH . '/' . $type . '/' . $filename;
        if ($this->fileService->checkFileExist($fullPath)) {
            return \Response::download($fullPath);
        }
    }

    public function union(ParserUnionRequest $request)
    {
        $files = $request->input('selected');
        $type = $request->input('type');
        if (count($files) < 2) {
            return back()
                ->withErrors('Choose minimum 2 files for union process');
        }
        if ($this->fileService->union($files, $type)) {
            return redirect()
                ->route('parser.parsed', $type);
        }
    }

}
