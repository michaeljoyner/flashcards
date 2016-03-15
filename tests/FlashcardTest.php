<?php
use App\Flashcards\Flashcard;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 3/15/16
 * Time: 9:26 AM
 */
class FlashcardTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *@test
     */
    public function new_flashcards_can_be_created_from_a_word_collection()
    {
        $collection = collect($this->testDummyThreeWordArray);

        Flashcard::createFromCollection($collection);

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
    }

    /**
     *@test
     */
    public function it_wont_add_a_word_from_a_collection_if_already_exists()
    {
        $words = [
            [
                'eng' => 'pig',
                'py' => 'ju',
                'trad' => 'ㄘ'
            ],
            [
                'eng' => 'pig',
                'py' => 'ju',
                'trad' => 'ㄘ'
            ]
        ];
        Flashcard::createFromCollection(collect($words));

        $this->assertCount(1, Flashcard::all());
    }
}