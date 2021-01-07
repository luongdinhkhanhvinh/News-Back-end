<?php

namespace App\Http\Controllers\api\v1;

use App\Models\AppSettings;
use App\Models\News;
use App\Models\NewsComment;
use App\Models\NewsFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends BaseAPIController
{

    public function show($newsId)
    {
        $news = News::with('category', 'user', 'topComments')
            ->withCount('comments')
            ->where('id', $newsId)->first();
        $otherNews = News::with('category', 'user', 'topComments')
            ->withCount('comments')
            ->where('id', '<>', $news->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        return $this->responseJSON([
            'news' => $news,
            'otherNews' => $otherNews->shuffle()
        ]);
    }

    public function search(Request $request)
    {
        $news = News::with('category', 'user', 'topComments')
            ->withCount('comments')
            ->where('title', 'like', '%' . $request->searchText . '%')
            ->where('content', 'like', '%' . $request->searchText . '%')
            ->get();
        return $this->responseJSON($news);
    }

    public function favoritedNews()
    {
        $list = NewsFavorite::with('news')
            ->where('user_id', Auth::user()->id)
            ->get();

        return $this->responseJSON($list->map(function ($item) {
            return $item['news'];
        }));
    }

    public function favoriteNews(Request $request)
    {
        $isFavorited = filter_var($request->isFavorited, FILTER_VALIDATE_BOOLEAN);
        $newsId = $request->newsId;

        if ($isFavorited) {
            if (!NewsFavorite::where('news_id',  $newsId)->where('user_id', Auth::user()->id)->exists()) {
                NewsFavorite::create([
                    'news_id' => $newsId,
                    'user_id' => Auth::user()->id,
                ]);
            }
        } else {
            NewsFavorite::where('news_id',  $newsId)->where('user_id', Auth::user()->id)->delete();
        }

        return $this->responseJSON(
            $request->input()
        );
    }
}
