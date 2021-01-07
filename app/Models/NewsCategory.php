<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = "news_categories";
    protected $fillable = ['name', 'color', 'image_name'];

    public function news()
    {
        return $this->hasMany('App\Models\News', 'category_id');
    }
}
