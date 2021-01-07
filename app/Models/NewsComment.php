<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    protected $table = "news_comments";
    protected $fillable = [
        'news_id',
        'user_id',
        'message',
        'approved',
    ];

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
