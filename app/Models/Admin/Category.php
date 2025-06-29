<?php

namespace App\Models\Admin;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'status'
    ];

    public function videos(){
        return $this->hasMany(Video::class, 'category_id');
    }

    public function search_videos(){
        return $this->hasMany(Video::class, 'category_id');
    }
}
