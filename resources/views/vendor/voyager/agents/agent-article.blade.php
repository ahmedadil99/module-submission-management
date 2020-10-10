@extends('voyager::master')
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="panel panel-bordered">
        <div class="panel-body">
          <h3>Offer Status</h3>
          <h5>Writer's amount offered ${{$article->amount_offered}}</h5>
          <form role="form" class="form-edit-add" action="/admin/agent/offer/{{$article->id}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          @if($article->status == 'offer_made')
            <div class="panel-footer">
                <button type="submit" value="accepted" name="offer" class="btn btn-primary save">Accept Offer</button>
                <button type="submit" value="rejected" name="offer" class="btn btn-primary save">Reject Offer</button>
                <button type="submit" value="counter" name="offer" class="btn btn-primary save">Counter Offer</button>
            </div>
          </form>
          @elseif($article->status == 'offer_accepted')
            <h5>Offer of ${{$article->amount_offered}} is accepted by you</h5>
            <h4>The offer is not yet accpeted by the Writer</h5>
            <p>Once the writer will accpet the offer and pay, you will be notified</p>
          @elseif($article->status == 'offer_rejected')
            <button type="submit" value="reconsider_offer" name="offer" class="btn btn-primary save">Reconsider Offer</button>
          @elseif($article->status == 'counter_offer')
              <label class="control-label">Counter Offer Amount</label>
              <input required="" type="text" class="form-control" name="counter_amount_offered" placeholder="Offered Amount" value="{{$article->counter_offer}}" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
              <button type="submit" value="counter_amount" name="offer" class="btn btn-primary save">Counter Offer</button>
          
          @elseif($article->status == 'counter_amount_offered')
          <h5>You have made the offer of ${{$article->counter_offer}} to the writer</h5>
          
          <h4>The offer is not yet accpeted by the Writer</h5>
          <p>Once the writer will accpet the offer and pay, you will be notified</p>
          @elseif($article->status == 'payment_made')
          <h5> Amount of ${{$article->amount_paid}} has been received</h5>
          @endif
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-bordered">
          <div class="panel-body">
            <h1>{{$article->article->Title}}</h1>
            <p>
            @if($article->status == 'payment_made' || $article->status == 'offer_accepted')
              {!! $article->article->content !!}
            @else
              {{substr_replace(strip_tags($article->article->content), "...", 500)}}
              <h3>Please accept Writer's offer to view complete article</h3>
            @endif
            </p>
          </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="panel panel-bordered">
        <div class="panel-body">
          <h3>Messages</h3>
          @foreach($messages as $message)
            <div class="row">
              <div class="col-md-12">
                @if($role == 'Agent' && $message->agent_id != null)
                <div class="alert alert-info" role="alert">
                    <b>You: </b>{{$message->message}}
                    <hr>
                    <small>{{date_format($message->created_at, 'd/m/Y h:i A')}}</small>
                </div>
                @endif
                @if($role == 'Agent' && $message->writer_id != null)
                <div class="alert alert-success text-right" role="alert">
                    <b>Writer: </b>{{$message->message}}
                    <hr>
                    <small>{{date_format($message->created_at, 'd/m/Y h:i A')}}</small>
                </div>
                @endif
                
              </div>
            </div>
          @endforeach
          <form role="form" class="form-edit-add" action="/admin/agents/send-message/{{$article->id}}" method="POST" enctype="multipart/form-data">
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