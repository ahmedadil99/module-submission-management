@extends('voyager::master')

@section('content')
   <div class="page-content read container-fluid">
      <div class="row">
         <div class="panel-body">
            @foreach($agents as $agent)
            
               <div class="card" style="width: 18rem;">
                  <img class="card-img-top" src="/storage/{{ $agent->avatar }}" alt="Card image cap">
                  <div class="card-body">
                     <h5 class="card-title">{{ $agent->name }}</h5>
                     <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                     <a href="#" class="btn btn-primary" title="View Profile"><span class="voyager-eye"></span></a>
                     <a href="/admin/agents/assign-article/{{ $agent->id }}" class="btn btn-primary" title="Assign Article"><span class="voyager-edit"></span></a>
                  </div>
               </div>
            @endforeach
         </div>
      </div>
   </div>
@stop