<?php

namespace App\Http\Controllers;

use App\Library\FileHelper;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoriesController extends Controller
{
    public $validationRules = [
        'related_news_id' => 'required',
        'title' => 'required',
        'content' => 'required',
        'thumbnail_image_name' => 'required',
        'story_image_name' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Story::orderBy('created_at', 'desc')->get();
        return view('stories.index', ['stories' => $stories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $news = News::where('visible', 1)
            ->where('approved', 1)
            ->get();
        return view('stories.create', ['news' => $news]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $thumbnailImageName = $request->input('thumbnail_image_name');
        $storyImageName = $request->input('story_image_name');
        $story = new Story;
        $story->user_id = Auth::user()->id;
        $story->related_news_id = $request->input('related_news_id');
        $story->title = $request->input('title');
        $story->content = $request->input('content');
        $story->visible = filter_var($request->input('visible'), FILTER_VALIDATE_BOOLEAN);
        $story->thumbnail_image_name = $thumbnailImageName;
        $story->story_image_name = $storyImageName;

        $story->save();
        FileHelper::moveCacheToImages($thumbnailImageName);
        FileHelper::moveCacheToImages($storyImageName);
        return redirect('stories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $story = Story::findOrFail($id);
        $news = News::all();
        return view('stories.edit', ['story' => $story, 'news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $this->validationRules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $thumbnailImageName = $request->input('thumbnail_image_name');
        $storyImageName = $request->input('story_image_name');
        $story = Story::findOrFail($id);
        if ($story->thumbnail_image_name != $thumbnailImageName) {
            FileHelper::removeImageFile($story->thumbnail_image_name);
        }
        if ($story->story_image_name != $storyImageName) {
            FileHelper::removeImageFile($story->story_image_name);
        }
        $story->related_news_id = $request->input('related_news_id');
        $story->title = $request->input('title');
        $story->content = $request->input('content');
        $story->visible = filter_var($request->input('visible'), FILTER_VALIDATE_BOOLEAN);
        $story->thumbnail_image_name = $thumbnailImageName;
        $story->story_image_name = $storyImageName;
        $story->update();

        FileHelper::moveCacheToImages($thumbnailImageName);
        FileHelper::moveCacheToImages($storyImageName);

        return redirect('stories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        FileHelper::removeImageFile($story->thumbnail_image_name);
        FileHelper::removeImageFile($story->story_image_name);
        $story->delete();
        return redirect('stories');
    }
}
