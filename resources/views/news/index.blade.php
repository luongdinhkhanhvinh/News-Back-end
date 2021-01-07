@extends('layouts.master')

@section('content')

<div class="d-flex flex-row align-items-center">
    <h3>
        News
    </h3>
    <a class="btn btn-info btn-sm ml-auto" href="/news/create">Create News</a>
</div>

<hr />

<table id="newsTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Featured
            </th>
            <th>
                Title
            </th>
            <th>
                Category
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
        @foreach ($news as $item)
        <tr>
            <td>
                <input type="checkbox" disabled {{ filter_var($item->featured, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }} />
            </td>
            <td>
                {{$item->title}}
            </td>
            <td>
                {{$item->category->name}}
            </td>
            <td>
                {{ filter_var($item->visible, FILTER_VALIDATE_BOOLEAN) ? 'visible' : 'unvisible' }}
            </td>
            <td>
                {{$item->created_at}}
            </td>
            <td>
                @if ($item->approved == 0)
                @if (Auth::user()->is_admin)
                <a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="approveNews(this, {{ $item->id }});"><span data-feather="check"></span> Approve</a>
                @else
                <small><b>not approved yet</b></small>
                @endif
                @endif
                <a href="{{ route('news.edit', ['id' => $item->id]) }}" class="btn btn-info btn-sm"><span data-feather="edit-2"></span></a>
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'news'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#newsTable");
    });
    function approveNews(btn, id) {
        $.ajax({
            type: "POST",
            url: "/news/approve_news",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            dataType: 'json',
            data: {
                newsId: id
            },
            success: () => {
                $(btn).hide();
            }
        })
    }
</script>
@endpush
