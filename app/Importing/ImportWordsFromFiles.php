<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 11:01 AM
 */

namespace App\Importing;


use App\Flashcards\Flashcard;
use App\Words\WordCollectionBuilder;
use App\Words\WordExtractor;
use Symfony\Component\DomCrawler\Crawler;

class ImportWordsFromFiles
{

    public $newList;

    /**
     * @var ImportList
     */
    private $importList;


    public function __construct(ImportList $importList)
    {
        $this->importList = $importList;
    }

    public function import()
    {
        $this->newList = $this->importList->getNewList();
        collect($this->newList)->each(function($file) {
            $words = (new WordCollectionBuilder(new WordExtractor(new Crawler())))->fromFile(storage_path('app/'.$file));
            Flashcard::createFromCollection($words);
            ProcessedFile::create(['filepath' => $file]);
        });
    }

}