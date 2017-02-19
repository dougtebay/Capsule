@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Collection</div>
                <div class="panel-body">
                @if (isset($collection))
                    <form action="/collections/{{ $collection->id }}" method="POST">
                    {{ method_field('PATCH') }}
                @else
                    <form action="/collections" method="POST">
                @endif
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text"
                                   id="title"
                                   class="form-control"
                                   name="title"
                                   value="@if (isset($collection->title)){{ $collection->title }}@endif">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control" name="description" rows="2" cols="40">@if (isset($collection->description)){{ $collection->description }}@endif</textarea>
                        </div>
                        @if (isset($collection))
                            <button type="submit" class="btn btn-default">Update</button>
                        @else
                            <button type="submit" class="btn btn-default">Create</button>
                        @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
