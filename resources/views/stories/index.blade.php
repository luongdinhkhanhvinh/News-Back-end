@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        Stories
    </h3>
    <a class="btn btn-info btn-sm ml-auto" href="/stories/create">Create Story</a>
</div>

<hr />

<table id="storiesTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Title
            </th>
            <th>
                User
            </th>
            <th>
                Releated News
            </th>
            <th>
                Visibility
            </th>
            <th>
                Created Date
            </th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($stories as $item)
        <tr>
            <td>
                {{$item->title}}
            </td>
            <td>
                {{$item->user->username}}
            </td>
            <td>
                {{$item->related_news->title}}
            </td>
            <td>
                {{ filter_var($item->visible, FILTER_VALIDATE_BOOLEAN) ? 'visible' : 'unvisible' }}
            </td>
            <td>
                {{$item->created_at}}
            </td>
            <td>
                <a href="{{ route('stories.edit', ['id' => $item->id]) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'stories'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#storiesTable");
    });
</script>
@endpush
