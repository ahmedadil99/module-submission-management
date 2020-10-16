@extends('voyager::master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('content')
<div class="row">
    <div class="col-md-8">
      <div class="panel panel-bordered">
          <div class="panel-body">
            <h1>{{$article->Title}}</h1>
            <p>
              {!! $article->content !!}
            </p>
          </div>
      </div>
    </div>
@stop