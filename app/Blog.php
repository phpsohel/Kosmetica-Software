<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'blog_title',
        'blog_title_ar',
        'blog_image',
        'blog',
        'featured'
    ];

}
