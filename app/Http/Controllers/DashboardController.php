<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsComment;
use App\Models\Story;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $newsCount = News::all()->count();
        $newsCommentCount = NewsComment::all()->count();
        $storyCount = Story::all()->count();
        $userCount = User::all()->count();

        $lastComments = NewsComment::orderBy('approved', 'asc')->orderBy('created_at', 'desc')->take(10)->get();

        $viewData = (object)[
            "newsCount" => $newsCount,
            "newsCommentCount" => $newsCommentCount,
            "userCount" => $userCount,
            "storyCount" => $storyCount,
            "lastComments" => $lastComments,
        ];

        return view('dashboard.index')->with("viewData", $viewData);
    }
}
