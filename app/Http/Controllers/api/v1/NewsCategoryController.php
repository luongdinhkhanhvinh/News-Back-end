<?php

namespace App\Http\Controllers\api\v1;

use App\Models\News;
use App\Models\NewsCategory;

class NewsCategoryController extends BaseAPIController
{
    public function index()
    {
        $newsCategories = NewsCategory::withCount('news')->get();
        return $this->responseJSON($newsCategories);
    }

    public function news($categoryId)
    {
        $news = News::with('category', 'user', 'topComments')
            ->withCount('comments')
            ->where('category_id', $categoryId)
            ->where('visible', 1)
            ->where('approved', 1)
            ->orderByRaw('news.created_at DESC')
            ->get();

        return $this->responseJSON($news);
    }
}
