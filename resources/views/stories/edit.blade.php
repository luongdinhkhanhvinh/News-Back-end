@extends('layouts.master')

@section('content')

<h1>Edit</h1>

<h4>Story</h4>
<hr />
<div class="row">
    <div class="col-xl-12">
        <form action="{{route("stories.update", ['id' => $story->id ])}}" method="POST">
            {{ csrf_field() }}
            @method('PUT')
            <input type="hidden" id="thumbnail_image_name" name="thumbnail_image_name" value="{{ old('thumbnail_image_name', $story->thumbnail_image_name) }}" />
            <input type="hidden" id="story_image_name" name="story_image_name" value="{{ old('story_image_name', $story->story_image_name) }}" />

            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="related_news_id" class="control-label">Related News</label>
                        <select name="related_news_id" class="form-control">
                            @foreach ($news as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('related_news_id', $story->related_news_id) ? "selected" : "" }}>
                                {{ $item->title }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-validation-error text-danger">{{$errors->first('related_news_id')}}</small>
                    </div>
                </div>
                <div class="col-sm-3 mt-2">
                    <div class="form-group form-check mt-4">
                        <label class="form-check-label">
                            <input name="visible" type="checkbox" {{ filter_var(old('visible', $story->visible), FILTER_VALIDATE_BOOLEAN) ? "checked" : "" }} class="form-check-input" /> Visible
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Title</label>
                <input name="title" class="form-control" value="{{ old('title', $story->title) }}" required />
                <small class="text-validation-error text-danger">{{ $errors->first('title') }}</small>
            </div>
            <div class="form-group">
                <label class="control-label">Content</label>
                <textarea name="content" class="form-control textarea-editor">{{ old('content', $story->content) }}</textarea>
                <small class="text-validation-error text-danger">{{ $errors->first('content') }}</small>
            </div>
            <div class="form-group">
                <label class="control-label">Thumbnail Photo (square)</label>
                <input id="imageFileForThumbnail" type="file" required />
                <small class="text-validation-error text-danger">{{$errors->first('thumbnail_image_name')}}</small>
            </div>
            <div class="form-group">
                <label class="control-label">Story Photo (portrait)</label>
                <input id="imageFileForStory" type="file" required />
                <small class="text-validation-error text-danger">{{$errors->first('story_image_name')}}</small>
            </div>
            <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{{route('news.index')}}">Back to List</a>
</div>

@endsection

@push('scripts')
@include('partials.file_pond_scripts')
<script>
    $(document).ready(() => {
        $('.textarea-editor').summernote({
            height: 300
        });
        createFilePond("imageFileForThumbnail", "thumbnail_image_name");
        createFilePond("imageFileForStory", "story_image_name");
    });
</script>
@endpush
