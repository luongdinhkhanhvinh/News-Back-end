@extends('layouts.master')

@section('content')

<h3>
    News Comments
</h3>

<hr />

<table id="newsCommentsTable" class="table table-striped">
    <thead>
        <tr>
            <th>
                Message
            </th>
            <th>
                News Title
            </th>
            <th>
                User
            </th>
            <th>
                Created Date
            </th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($comments as $item)
        <tr>
            <td>
                {{$item->message}}
            </td>
            <td>
                {{$item->news->title}}
            </td>
            <td>
                {{$item->user->username}}
            </td>
            <td>
                {{$item->created_at}}
            </td>
            <td>
                @if (Auth::user()->is_admin && $item->approved == 0)
                <a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="approveComment(this, {{ $item->id }});"><span data-feather="check"></span> Approve</a>
                @endif
                <a href="javascript:void(0);" data-entity-id="{{$item->id}}" class="btn btn-danger btn-sm delete-btn"><span data-feather="trash-2"></span></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('partials.delete_confirm_modal', ['actionName' => 'news_comments'])

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#newsCommentsTable");
    });
    function approveComment(btn, id) {
        $.ajax({
            type: "POST",
            url: "/news_comments/approve_comment",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            dataType: 'json',
            data: {
                commentId: id
            },
            success: () => {
                $(btn).hide();
            }
        })
    }
</script>
@endpush
