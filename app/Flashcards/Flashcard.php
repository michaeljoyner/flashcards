<?php

namespace App\Flashcards;

use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    protected $table = 'flashcards';

    protected $fillable = ['eng', 'py', 'trad'];

    public static function createFromCollection($collection)
    {
        $collection->each(function($item) {
            if(! static::where('eng', $item['eng'])->where('py', $item['py'])->first())
            static::create($item);
        });
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id');
    }

    public function classifyAs($classification)
    {
        if(! $classification instanceof Classification) {
            $classification = $this->normaliseClassification($classification);
        }

        $this->classification()->associate($classification);
        $this->save();
    }

    public static function classifyBy($qualifies, $classification)
    {
        static::whereNull('classification_id')->get()->each(function($flashcard) use ($qualifies, $classification) {
            if($qualifies($flashcard)) {
                $flashcard->classifyAs($classification);
            }
        });
    }

    private function normaliseClassification($classification)
    {
        return Classification::findOrFail($classification);
    }
}
