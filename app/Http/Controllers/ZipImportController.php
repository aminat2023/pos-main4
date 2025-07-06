<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZipImportController extends Controller
{
    public function unzipFile()
    {
        $zip = new \ZipArchive;

        $pathToZip = storage_path('app/imports/myfile.zip');
        $extractTo = storage_path('app/extracted/');

        if ($zip->open($pathToZip) === true) {
            $zip->extractTo($extractTo);
            $zip->close();
            return '✅ Unzipped successfully!';
        } else {
            return '❌ Failed to open the zip file.';
        }
    }
}
