<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_keywords',
        'meta_description'
    ];
}
