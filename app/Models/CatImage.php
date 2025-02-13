<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatImage extends Model
{
    /** @use HasFactory<\Database\Factories\CatImageFactory> */
    use HasFactory;

    protected $table = 'cat_images';
    protected $fillable = ['_id', 'mimetype', 'size', 'tags'];

    protected $casts = [
        'tags' => 'json',
    ];
}
