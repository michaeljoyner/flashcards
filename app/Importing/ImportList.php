<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 10:30 AM
 */

namespace App\Importing;


use Illuminate\Support\Facades\Storage;

class ImportList
{
    protected $directory = 'raw_imports';

    public function getNewList()
    {
        $files = collect(Storage::files($this->directory));

        return $files->filter(function($filepath) {
            return ! ProcessedFile::hasProcessed($filepath);
        })->toArray();
    }

}