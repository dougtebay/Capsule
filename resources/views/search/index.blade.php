@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($results as $result)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ "@{$result->user->screen_name}" }}</div>
                    <div class="panel-body">{{ $result->text }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
