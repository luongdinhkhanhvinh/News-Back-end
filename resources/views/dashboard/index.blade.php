@extends('layouts.master')

@section('content')

<h1 class="mt-2">Welcome, {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h1>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="info-box">
            <div class="icon-container">
                <span data-feather="tv"></span>
            </div>
            <div class="info-rows-container">
                <div class="title-text">News</div>
                <div class="value-text">{{$viewData->newsCount}}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="info-box">
            <div class="icon-container" style="background-color: #dd4b39 !important">
                <span data-feather="message-circle"></span>
            </div>
            <div class="info-rows-container">
                <div class="title-text">Comments</div>
                <div class="value-text">{{$viewData->newsCommentCount}}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="info-box">
            <div class="icon-container" style="background-color: #00a65a !important">
                <span data-feather="layers"></span>
            </div>
            <div class="info-rows-container">
                <div class="title-text">Stories</div>
                <div class="value-text">{{$viewData->storyCount}}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="info-box">
            <div class="icon-container" style="background-color: #f39c12 !important">
                <span data-feather="user"></span>
            </div>
            <div class="info-rows-container">
                <div class="title-text">Users</div>
                <div class="value-text">{{$viewData->userCount}}</div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col">
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Last 10 Comments</h5>

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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewData->lastComments as $item)
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        createTable("#newsCommentsTable", {
            bLengthChange: false,
            searching: false
        });
    });
</script>
@endpush
