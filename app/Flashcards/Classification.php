<?php

namespace App\Flashcards;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $table = 'classifications';

    protected $fillable = [
        'name',
        'description'
    ];
}
