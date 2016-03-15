<?php
use App\Words\WordExtractor;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 8:01 AM
 */
class WordExtractorTest extends TestCase
{

    /**
     *@test
     */
    public function it_can_load_valid_html_from_a_text_file()
    {
        $file = 'tests/assets/example.txt';
        $extractor = new WordExtractor(new Crawler());
        $extractor->loadFromFile($file);

        $this->assertNotNull($extractor->html);
    }

    /**
     *@test
     */
    public function it_throws_an_exception_if_file_does_not_exist()
    {
        $file = 'tests/assets/does_not_exist.txt';
        $extractor = new WordExtractor(new Crawler());

        $this->setExpectedException(\InvalidArgumentException::class);
        $extractor->loadFromFile($file);
    }

    /**
     * @test
     */
    public function it_can_find_matches_for_a_given_selector()
    {
        $file = 'tests/assets/has_matches_for_lesson_translate_parts.txt';
        $extractor = new WordExtractor(new Crawler());

        $extractor->loadFromFile($file)->selectFor('.lesson_translate_parts');

        $this->assertCount(1, $extractor->currentSelection);
    }

    /**
     *@test
     */
    public function it_can_return_the_correct_word_collection_for_a_given_html_document()
    {
        $file = 'tests/assets/contains_three_valid_words.txt';
        $extractor = new WordExtractor(new Crawler());
        $expected = [
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
        ];

        $collection = $extractor->loadFromFile($file)->selectFor('.lesson_translate_parts')->extractFromEach(['eng', 'py', 'trad']);
        $this->assertEquals($expected, $collection);
    }

}