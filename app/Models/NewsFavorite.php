<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class NewsFavorite extends Model
{
    protected $table = "news_favorites";
    protected $fillable = ['news_id', 'user_id'];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id')
            ->with('category', 'user', 'topComments')
            ->withCount('comments')
            ->where('visible', 1)
            ->where('approved', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
