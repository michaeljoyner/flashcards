<?php

use App\Flashcards\Classification;
use App\Flashcards\Flashcard;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FlashcardClassificationTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_flashcard_can_be_classified()
    {
        $flashcard = factory(Flashcard::class)->create();
        $classifaction = factory(Classification::class)->create();

        $flashcard->classifyAs($classifaction);

        $this->seeInDatabase('flashcards', [
            'id'                => $flashcard->id,
            'classification_id' => $classifaction->id
        ]);
    }

    /**
     *@test
     */
    public function unclassified_flashcards_can_be_classified_based_on_number_of_words()
    {
        $vocab = factory(Classification::class)->create();
        $phrase = factory(Classification::class)->create();
        $sentence = factory(Classification::class)->create();

        $card1 = factory(Flashcard::class)->create(['eng' => 'summer']);
        $card2 = factory(Flashcard::class)->create(['eng' => 'summer is host']);
        $card3 = factory(Flashcard::class)->create(['eng' => 'We eat ice cream when the summer is host']);

        Flashcard::classifyBy(function($flashcard) {
            return str_word_count($flashcard->eng) < 3;
        }, $vocab);

        Flashcard::classifyBy(function($flashcard) {
            $wordCount = str_word_count($flashcard->eng); 
            return $wordCount > 2 && $wordCount < 5;
        }, $phrase);

        Flashcard::classifyBy(function($flashcard) {
            $wordCount = str_word_count($flashcard->eng);
            return $wordCount > 4;
        }, $sentence);

        $card1 = Flashcard::findOrFail($card1->id);
        $card2 = Flashcard::findOrFail($card2->id);
        $card3 = Flashcard::findOrFail($card3->id);

        $this->assertEquals($card1->classification->id, $vocab->id);
        $this->assertEquals($card2->classification->id, $phrase->id);
        $this->assertEquals($card3->classification->id, $sentence->id);
    }
}
