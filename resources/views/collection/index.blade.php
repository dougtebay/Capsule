@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($collections as $collection)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $collection->title }}</div>
                    <div class="panel-body">{{ $collection->description }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
