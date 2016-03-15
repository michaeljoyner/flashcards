<?php

namespace App\Importing;

use Illuminate\Database\Eloquent\Model;

class ProcessedFile extends Model
{
    protected $table = 'processed_files';

    protected $fillable = ['filepath'];

    public static function hasProcessed($filepath)
    {
        return !! static::where('filepath', $filepath)->count();
    }
}
