<?php
use App\Flashcards\Flashcard;
use App\Importing\ImportList;
use App\Importing\ImportWordsFromFiles;
use App\Words\WordCollectionBuilder;
use App\Words\WordExtractor;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 10:48 AM
 */
class ImportWordsFromFilesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *@test
     */
    public function it_imports_all_the_words_from_all_the_files_as_expected()
    {
        $this->setUpTestFiles();
        $list = new ImportList();
        $importer = new ImportWordsFromFiles($list);
        $importer->import();

        $this->seeAllSixFlashCardsInDatabase();

        $this->removeTestFiles();
    }

    protected function setUpTestFiles()
    {
        Storage::put('raw_imports/test1.txt', file_get_contents('tests/assets/contains_three_valid_words.txt'));
        Storage::put('raw_imports/test2.txt', file_get_contents('tests/assets/contains_three_more_valid_words.txt'));
    }

    protected function removeTestFiles()
    {
        Storage::delete([
            'raw_imports/test1.txt',
            'raw_imports/test2.txt'
        ]);
    }

    private function seeAllSixFlashCardsInDatabase()
    {
        $this->seeInDatabase('flashcards', [
            'eng' => 'pig',
            'py' => 'ju'
        ]);
        $this->seeInDatabase('flashcards', [
            'eng' => 'dog',
            'py' => 'goa'
        ]);
        $this->seeInDatabase('flashcards', [
            'eng' => 'cat',
            'py' => 'mao'
        ]);
        $this->seeInDatabase('flashcards', [
            'eng' => 'you',
            'py' => 'ni'
        ]);
        $this->seeInDatabase('flashcards', [
            'eng' => 'we',
            'py' => 'women'
        ]);
        $this->seeInDatabase('flashcards', [
            'eng' => 'they',
            'py' => 'tamen'
        ]);
    }


}