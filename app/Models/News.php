<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = "news";
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'content',
        'image_name',
        'approved',
        'featured',
        'visible',
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\NewsComment', 'news_id')->where('approved', 1);
    }

    public function topComments()
    {
        return $this->hasMany('App\Models\NewsComment', 'news_id')->with('user')->where('approved', 1)->orderBy('created_at', 'desc')->take(3);
    }
}
