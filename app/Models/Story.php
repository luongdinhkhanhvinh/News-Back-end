<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $table = "stories";
    protected $fillable = [
        'related_news_id',
        'user_id',
        'title',
        'content',
        'thumbnail_image_name',
        'story_image_name',
        'visible',
    ];

    public function related_news()
    {
        return $this->belongsTo(News::class, 'related_news_id')->with('category', 'topComments');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
