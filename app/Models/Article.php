<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content',
        'author',
        'source',
        'category',
        'published_at'
    ];

}
