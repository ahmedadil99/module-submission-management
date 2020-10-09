@extends('voyager::master')

@section('content')
   <div class="page-content read container-fluid">
      <div class="panel-body">
      <div class="d-flex flex-row">
        
            @foreach($agents as $agent)
               @if (!$agent->hasRole('Agent'))
                  @continue
               @endif
                  <div class="col-sm-3 d-flex align-items-stretch">
                     <div class="card">
                        <img class="card-img-top" src="/storage/{{ $agent->avatar }}" width="100%" alt="Card image cap">
                        <div class="card-body">
                           <h5 class="card-title">{{ $agent->name }}</h5>
                           <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                           <a href="/admin/agents/{{ $agent->id }}" class="btn btn-primary" title="View Profile"><span class="voyager-eye"></span></a>
                           <a href="/admin/agents/assign-article/{{ $agent->id }}" class="btn btn-primary" title="Assign Article"><span class="voyager-edit"></span></a>
                        </div>
                     </div>
                  </div>
               @endforeach
         </div>
      </div>
   </div>
@stop