@extends('voyager::master')

@section('content')
   <div class="page-content read container-fluid">
      <div class="panel-body">
      <div class="d-flex flex-row">
        
            @foreach($myAricles as $article)
                  <div class="col-sm-3 d-flex align-items-stretch">
                     <div class="card">
                        <div class="card-body">
                           <h5 class="card-title">{{ $article->article->Title }}</h5>
                           <p class="card-text">{{substr_replace(strip_tags($article->article->content), "...", 100)}}</p>
                           <a href="/admin/agent/view-article/{{ $article->id }}" class="btn btn-primary" title="View Profile"><span class="voyager-eye"></span></a>
                        </div>
                     </div>
                  </div>
               @endforeach
         </div>
      </div>
   </div>
@stop