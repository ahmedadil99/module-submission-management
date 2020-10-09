@extends('voyager::master')

@section('content')
   <div class="container-fluid">
   @if(isset($agent))
   <div class="row" style="padding: 1em;">
      <div class="col-lg-8">
         <div class="row">
            <div class="col-lg-6" >
               <div class="card" style="padding: 1em;">
                     <h1 class="">Articles not Transfered</h1>
                     <ul class="list-group">
                        @foreach($articles as $article)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div class="d-flex w-100 justify-content-between">
                              <h3 class="mb-1">{{$article->Title}}</h3>
                           </div>
                           <p class="mb-1">{{substr_replace(strip_tags($article->content), "...", 100)}}</p>
                           <a style="position: absolute;right: 14px; bottom:0;" href="/admin/agents/assign-atircle/{{$agent->id}}/{{$article->id}}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                 <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Assign Article</span>
                           </a>
                           <small>Created: {{date_format($article->created_at, 'd/m/Y')}}</small>
                           
                           <br>
                        </li>
                        @endforeach
                     </ul>
               </div>
            </div>
            <div class="col-lg-6">
            <div class="card" style="padding: 1em;">
                     <h1 class="">Articles Transfered</h1>
                     <ul class="list-group">
                        @foreach($articlesAssigned as $articleAssigned)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                           <div class="d-flex w-100 justify-content-between">
                              <h3 class="mb-1">{{$articleAssigned->article->Title}}</h3>
                           </div>
                           <p class="mb-1">{{substr_replace(strip_tags($articleAssigned->article->content), "...", 100)}}</p>
                           <a style="position: absolute;right: 60px; bottom:0;" href="/admin/articles/{{$articleAssigned->article_id}}/edit" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                 <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm"></span>
                           </a>
                           <a style="position: absolute;right: 14px; bottom:0;" href="/admin/agents/view-article/{{$articleAssigned->article_id}}" title="View" class="btn btn-sm btn-warning pull-right view">
                                 <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm"></span>
                           </a>
                           <small>Created: {{date_format($articleAssigned->created_at, 'd/m/Y')}}</small>
                           
                           <br>
                        </li>
                        @endforeach
                     </ul>
               </div>
            </div>
         </div>
      </div>
      <div class="">
         <div class="card col-lg-4" style="padding: 1em; text-align:center;">
            <div><h1 class="">{{$agent->name}}</h1></div>
            <img class="card-img-top img-rounded" width="300" src="/storage/{{ $agent->avatar }}" alt="Card image cap">
            <div>
            <p><h5>Articles Transfered: {{count($articlesAssigned)}}</h5>
            </div>
         </div>
      </div>
   </div>
      @else
         <h1>Agent not found</h1>
      @endif
   </div>
@stop