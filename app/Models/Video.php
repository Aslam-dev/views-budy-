<?php

namespace App\Models;

use App\Models\Admin\Category;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'url',
        'view_id',
        'view_duration',
        'view_cost',
        'view_count',
        'amount',
        'amount_original',
        'status',
        'hidden'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class, 'video_id');
    }

    public function views(){
        return $this->hasMany(Earning::class, 'video_id')->get();
    }

    public function search_views(){
        return $this->hasMany(Earning::class, 'video_id');
    }

}
