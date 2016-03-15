<?php
use App\Words\WordCollectionBuilder;
use App\Words\WordExtractor;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 9:11 AM
 */
class WordCollectionBuilderTest extends TestCase
{

    /**
     *@test
     */
    public function it_builds_the_correct_collection_from_a_file()
    {
        $builder = new WordCollectionBuilder(new WordExtractor(new Crawler()));
        $collection = $builder->fromFile('tests/assets/contains_three_valid_words.txt');
        $expected = collect([
            [
                'eng' => 'pig',
                'py' => 'ju',
                'trad' => 'ㄘ'
            ],
            [
                'eng' => 'dog',
                'py' => 'goa',
                'trad' => 'ㄕ'
            ],
            [
                'eng' => 'cat',
                'py' => 'mao',
                'trad' => 'ㄙㄨㄜ'
            ]
        ]);

        $this->assertEquals($expected, $collection);
    }

}