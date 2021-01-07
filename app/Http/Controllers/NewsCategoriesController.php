<?php

namespace App\Http\Controllers;

use App\Library\FileHelper;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsCategoriesController extends BaseController
{
    public $validationRules = [
        'name' => 'required',
        'color' => 'required',
        'image_name' => 'required',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsCategories = NewsCategory::all();
        return view('news_categories.index')->with('newsCategories', $newsCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('news_categories.create');
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
        $imageName = $request->input('image_name');

        $newsCategory = new NewsCategory;
        $newsCategory->name = $request->input('name');
        $newsCategory->color = $request->input('color');
        $newsCategory->image_name = $imageName;
        $newsCategory->save();
        FileHelper::moveCacheToImages($imageName);
        return redirect('news_categories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $newsCategory = NewsCategory::findOrFail($id);
        return view('news_categories.edit')->with('newsCategory', $newsCategory);
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
        $imageName =  $request->input('image_name');
        $newsCategory = NewsCategory::findOrFail($id);
        if ($newsCategory->image_name != $imageName) {
            FileHelper::removeImageFile($newsCategory->image_name);
        }
        $newsCategory->name = $request->input('name');
        $newsCategory->color = $request->input('color');
        $newsCategory->image_name = $imageName;
        $newsCategory->update();
        FileHelper::moveCacheToImages($imageName);
        return redirect('news_categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $newsCategory = NewsCategory::findOrFail($id);
        $newsCategory->delete();
        FileHelper::removeImageFile($newsCategory->image_name);
        return redirect('news_categories');
    }
}
