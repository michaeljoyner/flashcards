<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 9:14 AM
 */

namespace App\Words;


class WordCollectionBuilder
{
    /**
     * @var WordExtractor
     */
    private $extractor;

    public function __construct(WordExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    public function fromFile($filepath)
    {
        return collect($this->extractor->loadFromFile($filepath)->selectFor('.lesson_translate_parts')->extractFromEach(['eng', 'py', 'trad']));
    }

}