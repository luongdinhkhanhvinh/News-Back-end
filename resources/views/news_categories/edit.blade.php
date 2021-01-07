@extends('layouts.master')

@section('content')

<h1>Edit</h1>

<h4>News Category</h4>
<hr />
<div class="row">
    <div class="col-md-4">
        <form action="{{ route('news_categories.update', ['id' => $newsCategory->id]) }}" method="POST">
            {{ csrf_field() }}
            @method('PUT')
            <input type="hidden" id="image_name" name="image_name" value="{{ old('image_name', $newsCategory->image_name) }}" />
            <div class="form-group">
                <label class="control-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $newsCategory->name) }}" required />
                <small class="text-validation-error text-danger">{{$errors->first('name')}}</small>
            </div>
            <div class="form-group">
                <label class="control-label">Color</label>
                <input type="text" id="color" name="color" class="form-control" style="color: white" value="{{ old('color', $newsCategory->color) }}" required />
                <small class="text-validation-error text-danger">{{$errors->first('color')}}</small>
            </div>
            <div class="form-group">
                <label class="control-label">Background Image</label>
                <input id="imageFile" type="file" required />
                <small class="text-validation-error text-danger">{{$errors->first('image_name')}}</small>
            </div>
            <div class="form-group">
                <input type="submit" value="Save" class="btn btn-primary" />
            </div>
        </form>
    </div>
</div>

<div>
    <a href="{{route('news_categories.index')}}">Back to List</a>
</div>

@endsection

@push('scripts')
@include('partials.file_pond_scripts')
<script>
    $(document).ready(() => {
        $('#color').colorpicker();
        $('#color').on('colorpickerChange', function(event) {
            $('#color').css('background-color', event.color.toString());
        });
        $('#color').css('background-color', $('#color').val());
        createFilePond("imageFile", "image_name");
    });
</script>
@endpush
