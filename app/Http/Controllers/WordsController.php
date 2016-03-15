<?php

namespace App\Http\Controllers;

use App\Flashcards\Flashcard;
use Illuminate\Http\Request;

use App\Http\Requests;

class WordsController extends Controller
{
    public function index()
    {
        return Flashcard::all()->shuffle()->values();
    }
}
