<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'posted_on',
        'img_original_url',
        'img',
        'created_at',
        'updated_at'
    ];

    
}
