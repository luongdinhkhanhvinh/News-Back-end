<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsComment;
use Illuminate\Support\Facades\Auth;

class NewsCommentController extends BaseAPIController
{
    public function index($newsId)
    {
        $comments = NewsComment::with('user')->where('news_id', $newsId)->where('approved', 1)->orderBy('created_at', 'desc')->get();
        return $this->responseJSON($comments);
    }

    public function store(Request $request, $newsId)
    {
        $comment = $request->comment;

        $autoApproveMode = env('AUTO_APPROVE_FOR_COMMENTS', false);
        $approved = filter_var($autoApproveMode, FILTER_VALIDATE_BOOLEAN);

        NewsComment::create([
            'news_id' => $newsId,
            'user_id' => Auth::user()->id,
            'message' => $comment,
            'approved' => $approved
        ]);

        return $this->responseJSON($request->input());
    }
}
