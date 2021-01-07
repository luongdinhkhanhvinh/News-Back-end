<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = NewsComment::orderBy('approved', 'asc')->orderBy('created_at', 'desc')->get();
        return view('news_comments.index')->with('comments', $comments);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = NewsComment::findOrFail($id);
        $comment->delete();
        return redirect('news_comments');
    }

    public function approveComment(Request $request)
    {
        if (!Auth::user()->is_admin) {
            throw new AuthorizationException();
        }
        $commentId = (int) $request->get('commentId');
        $comment = NewsComment::findOrFail($commentId);
        $comment->approved = 1;
        $comment->update();
        return response([(int) $commentId]);
    }
}
