@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($results as $result)
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ "@{$result->user_nickname}" }}</div>
                <div class="panel-body">{{ $result->text }}</div>
            </div>
        </div>
    </div>
    @endforeach
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="/search" method="GET">
                {{ csrf_field() }}
                <input type="hidden" name="query" value="{{ $query }}">
                <input type="hidden" name="max_id" value="{{ $results->last()->twitter_tweet_id }}">
                <input type="submit" value="Next">
            </form>
        </div>
    </div>
</div>
@endsection
