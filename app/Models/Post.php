<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
         use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'is_published',
        'publish_date',
        'meta_description',
        'tags'
    ];

}
