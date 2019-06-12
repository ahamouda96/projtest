@extends('layouts.app')

@section('content')
    <div class="col-sm-6">
        @foreach ($categories as $category)
            <div class="panel panel-default">
                <div class="panel-body">
                    {{ $category->name }}
                </div>
                
            </div>
        @endforeach
    </div>
@endsection