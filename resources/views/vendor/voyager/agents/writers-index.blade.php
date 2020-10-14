@extends('voyager::master')

@section('content')
   <div class="page-content read container-fluid">
      <div class="panel-body">
      <div class="d-flex flex-row">
        
            @foreach($writers as $writer)
               @if (!$writer->hasRole('Writer'))
                  @continue
               @endif
                  <div class="col-sm-3 d-flex align-items-stretch">
                     <div class="card">
                        <img class="card-img-top" src="/storage/{{ $writer->avatar }}" width="100%" alt="Card image cap">
                        <div class="card-body">
                           <h5 class="card-title">{{ $writer->name }}</h5>
                           <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                           <a href="/admin/writers/{{ $writer->id }}" class="btn btn-primary" title="View Profile"><span class="voyager-eye"></span></a>
                        </div>
                     </div>
                  </div>
               @endforeach
         </div>
      </div>
   </div>
@stop