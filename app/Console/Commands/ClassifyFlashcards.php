<?php

namespace App\Console\Commands;

use App\Flashcards\Classification;
use App\Flashcards\Flashcard;
use Illuminate\Console\Command;

class ClassifyFlashcards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcards:classify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigns unclassified flashcards an appropriate classification';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vocab = $this->getClassification('vocab', 'single words and short phrases');
        $phrase = $this->getClassification('phrase', 'phrases or idioms worth knowing');
        $sentence = $this->getClassification('sentence', 'longer phrases or complete sentences');

        Flashcard::classifyBy(function($flashcard) {
            return str_word_count($flashcard->py) < 3;
        }, $vocab);

        Flashcard::classifyBy(function($flashcard) {
            $wordCount = str_word_count($flashcard->py);
            return $wordCount > 2 && $wordCount < 5;
        }, $phrase);

        Flashcard::classifyBy(function($flashcard) {
            $wordCount = str_word_count($flashcard->py);
            return $wordCount > 4;
        }, $sentence);
    }

    protected function getClassification($name, $description)
    {
        $classification = Classification::where('name', $name)->first();

        if(! $classification) {
            $classification = Classification::create(['name' => $name, 'description' => $description]);
        }

        return $classification;
    }
}
