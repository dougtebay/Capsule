@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form action="search" method="POST">
                        {{ csrf_field() }}
                        <input type="text" name="search">
                        <input type="submit" value="Search">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
