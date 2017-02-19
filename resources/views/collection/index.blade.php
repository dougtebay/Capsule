@extends('layouts.app')

@section('content')
<div class="container">
@foreach ($collections as $collection)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $collection->title }}</div>
                <div class="panel-body">{{ $collection->description }}</div>
                <div class="panel-footer">
                    <div style="display:inline-block">
                        <form method="GET" action="/collections/{{ $collection->id }}">
                            <button type="submit" class="btn btn-default">View</button>
                        </form>
                    </div>
                    <div style="display:inline-block">
                        <form method="GET" action="/collections/{{ $collection->id }}/edit">
                            <button type="submit" class="btn btn-default">Edit</button>
                        </form>
                    </div>
                    <div style="display:inline-block">
                        <form method="POST" action="/collections/{{ $collection->id }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-default">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
