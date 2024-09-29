<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'content',
        'type',
        'description',
        'author',
        'source',
        'category',
        'url',
        'url_to_image',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'source' => 'array'
    ];
}
