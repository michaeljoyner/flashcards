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
}
