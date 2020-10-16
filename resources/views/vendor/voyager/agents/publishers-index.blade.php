@extends('voyager::master')

@section('content')
   <div class="page-content read container-fluid">
      <div class="panel-body">
      <div class="d-flex flex-row">        
            @foreach($publishers as $publisher)
                  <div class="col-sm-3 d-flex align-items-stretch">
                     <div class="card">
                        <img class="card-img-top" src="/storage/{{ $publisher->avatar }}" width="100%" alt="Card image cap">
                        <div class="card-body">
                           <h5 class="card-title">{{ $publisher->name }}</h5>
                           <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                           @if(App\Models\AgentArticle::where('publisher_id', $publisher->id)->where('article_id', $article_id)->first() != null)
                            <h4>Shared Already</h4>
                           @else
                           <a href="/admin/agent/share-article/{{ $article_id }}?publisher_id={{$publisher->id}}" class="btn btn-primary" title="View Profile"><span class="voyager-move"></span> Share</a>
                           @endif
                           <a href="/admin/agent/publisher-chat/{{ Auth::user()->id }}/{{$publisher->id}}" class="btn btn-primary" title="View Profile"><span class="voyager-mail"></span> Message</a>
                           
                        </div>
                     </div>
                  </div>
            @endforeach
         </div>
      </div>
   </div>
@stop