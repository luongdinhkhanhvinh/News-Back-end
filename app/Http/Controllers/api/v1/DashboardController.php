<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AppSettings;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Story;
use Exception;

class DashboardController extends BaseAPIController
{
    public function index()
    {
        $highlightedNews = News::with('category', 'user', 'topComments')
            ->withCount('comments')
            ->where('visible', 1)
            ->where('approved', 1)
            ->where('featured', 1)
            ->orderByRaw('news.created_at DESC')
            ->take(5)
            ->get();

        $news = News::with('category', 'user', 'topComments')
            ->withCount('comments')
            ->where('visible', 1)
            ->where('approved', 1)
            ->where('featured', 0)
            ->orderByRaw('news.created_at DESC')
            ->get();

        $categories = NewsCategory::withCount('news')->get();

        $topCategories = NewsCategory::take(5)->get();

        $stories = Story::with('related_news', 'user')
            ->where('visible', 1)
            ->orderByRaw('stories.created_at DESC')
            ->take(10)
            ->get();

        return $this->responseJSON(
            [
                'highlightedNews' => $highlightedNews,
                'news' => $news,
                'categories' => $categories,
                'topCategories' => $topCategories,
                'stories' => $stories,
            ]
        );
    }
}
