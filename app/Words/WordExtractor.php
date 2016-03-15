<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 8:05 AM
 */

namespace App\Words;


use Symfony\Component\DomCrawler\Crawler;

class WordExtractor
{
    public $html = null;
    public $currentSelection;
    /**
     * @var Crawler
     */
    private $crawler;

    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    public function loadFromFile($file)
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException('file [' . $file . '] must be a path to an existing file');
        }

        $this->html = file_get_contents($file);

        return $this;
    }

    public function selectFor($selector)
    {
        $this->crawler->addHtmlContent($this->html);

        $this->currentSelection = $this->crawler->filter($selector);

        return $this;
    }

    public function extractFromEach($attributes)
    {
        $result = [];
        $this->currentSelection->each(function ($node, $index) use ($attributes, &$result) {
            $result[$index] = [];
            foreach ($attributes as $attribute) {
                $result[$index][$attribute] = $node->attr($attribute);
            }
        });

        return $result;
    }

}