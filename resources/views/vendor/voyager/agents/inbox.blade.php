@extends('voyager::master')

@section('content')
   <div class="page-content read container-fluid">
      <div class="panel-body">
      <div class="d-flex flex-row">
          <ul class="nav nav-list">
            <li class="nav-header">Inboxr</li>
            @foreach($conversations as $conversation)
              <li class="active"><a href="#">Home</a></li>
            @endforeach
          </ul>           
       </div>
      </div>
   </div>
@stop