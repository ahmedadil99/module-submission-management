@extends('voyager::master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="panel panel-bordered">
        <div class="panel-body">
          <h3>Messages</h3>
          @foreach($messages as $message)
            <div class="row">
              <div class="col-md-12">
                @if($role == 'Agent' && $message->sender_id == Auth::user()->id)
                <div class="alert alert-info" role="alert">
                    <b>You: </b>&nbsp;&nbsp; {{$message->message}}
                    <hr>
                    <small>{{date_format($message->created_at, 'd/m/Y h:i A')}}</small>
                </div>
                @elseif($role == 'Publisher' && $message->sender_id == Auth::user()->id)
                <div class="alert alert-info" role="alert">
                    <b>You: </b>&nbsp;&nbsp; {{$message->message}}
                    <hr>
                    <small>{{date_format($message->created_at, 'd/m/Y h:i A')}}</small>
                </div>
                @else
                <div class="alert alert-success text-right" role="alert">
                    <b>Agent: </b> &nbsp;&nbsp;{{$message->message}}
                    <hr>
                    <small>{{date_format($message->created_at, 'd/m/Y h:i A')}}</small>
                </div>
                @endif
                
              </div>
            </div>
          @endforeach
          <form role="form" class="form-edit-add" action="/admin/agent/publisher-chat/{{$agent_id}}/{{$publisher_id}}" method="POST" enctype="multipart/form-data">
             <!-- CSRF TOKEN -->
              {{ csrf_field() }}
              <div class="form-group  col-md-12 ">
                <label class="control-label">Message</label>
                <input required="" type="text" class="form-control" name="message" placeholder="Type your message" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                <div class="panel-footer">
                  <button type="submit" class="btn btn-primary save">Send</button>
                </div>
              </form>
          </form>
        </div>
      </div>
    </div>
  </div>
@stop