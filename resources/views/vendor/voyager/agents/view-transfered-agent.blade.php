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
          <form role="form" class="form-edit-add" action="/admin/agents/update-offer/{{$articlesAssigned->id}}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
              @if($lastMessage == null || $lastMessage->status == 'restart_offer')
                  <div class="form-group  col-md-12">
                    <label class="control-label">Amount to offer</label>
                    <input required="" type="text" class="form-control" name="amount_offered" placeholder="Offered Amount" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    <label class="control-label">Message</label>
                    <input required="" type="text" class="form-control" name="message" placeholder="Type a message" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    <input type="hidden" name="status" value="offer_made"> 
                    <div class="panel-footer">
                      <button type="submit" class="btn btn-primary save">Make Offer</button>
                    </div>
                  </div>
              @elseif($lastMessage->status == 'offer_counter_start' && $lastMessage->writer_id != null)
                  <div class="form-group col-md-12">
                    <label class="control-label">Counter offer amount</label>
                    <input required="" type="text" class="form-control" name="amount_offered" placeholder="Offered Amount" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    <label class="control-label">Message</label>
                    <input required="" type="text" class="form-control" name="message" placeholder="Type a message" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                    <input type="hidden" name="status" value="counter_offer_made"> 
                    <div class="panel-footer">
                      <button type="submit" class="btn btn-primary save">Make Counter Offer</button>
                    </div>
                    <h5>Agent offer was ${{$lastMessage->amount}}</h5>
                  </div>
              @elseif($lastMessage->status == 'offer_made' && $lastMessage->writer_id != null)
                <h5>Offer of ${{$lastMessage->amount}} has been made by you.</h5>
                <small>{{date_format($lastMessage->created_at, 'd/m/Y h:i A')}}</small>
              @elseif($lastMessage->status == 'counter_offer_made' && $lastMessage->writer_id != null)
                <h5>Counter Offer of ${{$lastMessage->amount}} has been made by you.</h5>
                <small>{{date_format($lastMessage->created_at, 'd/m/Y h:i A')}}</small>
              @elseif($lastMessage->status == 'article_transfered' && $lastMessage->writer_id != null)
                <h5>Payemnt ${{$lastMessage->amount}} has been transfered to the agent.</h5>
                <small>{{date_format($lastMessage->created_at, 'd/m/Y h:i A')}}</small>
              @elseif($lastMessage->status == 'offer_rejected' && $lastMessage->writer_id != null)
                <h5>Offer of ${{$lastMessage->amount}} was rejected by you.</h5>
                <small>{{date_format($lastMessage->created_at, 'd/m/Y h:i A')}}</small>
                <br />
                <br />
                <button type="submit" value="restart_offer" name="status" class="btn btn-primary save">Negotiate Again</button>
              @elseif($lastMessage->status == 'offer_rejected' && $lastMessage->agent_id != null)
                <h5>Offer of ${{$lastMessage->amount}} were rejected by the agent.</h5>
                <small>{{date_format($lastMessage->created_at, 'd/m/Y h:i A')}}</small>  
              @elseif( ($lastMessage->status == 'offer_made' || $lastMessage->status == 'counter_offer_made' ) && $lastMessage->agent_id != null)
                <h5>Offer of ${{$lastMessage->amount}} has been made by the agent.</h5>
                <small>{{date_format($lastMessage->created_at, 'd/m/Y h:i A')}}</small>
                <br />
                <br />
                <label class="control-label">Message</label>
                <input required="" type="text" class="form-control" name="message" placeholder="Type a message" value="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAAAXNSR0IArs4c6QAAAfBJREFUWAntVk1OwkAUZkoDKza4Utm61iP0AqyIDXahN2BjwiHYGU+gizap4QDuegWN7lyCbMSlCQjU7yO0TOlAi6GwgJc0fT/fzPfmzet0crmD7HsFBAvQbrcrw+Gw5fu+AfOYvgylJ4TwCoVCs1ardYTruqfj8fgV5OUMSVVT93VdP9dAzpVvm5wJHZFbg2LQ2pEYOlZ/oiDvwNcsFoseY4PBwMCrhaeCJyKWZU37KOJcYdi27QdhcuuBIb073BvTNL8ln4NeeR6NRi/wxZKQcGurQs5oNhqLshzVTMBewW/LMU3TTNlO0ieTiStjYhUIyi6DAp0xbEdgTt+LE0aCKQw24U4llsCs4ZRJrYopB6RwqnpA1YQ5NGFZ1YQ41Z5S8IQQdP5laEBRJcD4Vj5DEsW2gE6s6g3d/YP/g+BDnT7GNi2qCjTwGd6riBzHaaCEd3Js01vwCPIbmWBRx1nwAN/1ov+/drgFWIlfKpVukyYihtgkXNp4mABK+1GtVr+SBhJDbBIubVw+Cd/TDgKO2DPiN3YUo6y/nDCNEIsqTKH1en2tcwA9FKEItyDi3aIh8Gl1sRrVnSDzNFDJT1bAy5xpOYGn5fP5JuL95ZjMIn1ya7j5dPGfv0A5eAnpZUY3n5jXcoec5J67D9q+VuAPM47D3XaSeL4AAAAASUVORK5CYII=&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                <br />
                <button type="submit" value="offer_accepted" name="status" class="btn btn-primary save">Accept Offer</button>
                <button type="submit" value="offer_rejected" name="status" class="btn btn-primary save">Reject Offer</button>
                <button type="submit" value="offer_counter_start" name="status" class="btn btn-primary save">Counter Offer</button>
              @endif
          </form>
            @if($lastMessage != null && $lastMessage->status == 'offer_accepted')
              <h5>You have accepted ${{$lastMessage->amount}} offer from agent</h5>
                <small>{{date_format($lastMessage->created_at, 'd/m/Y h:i A')}}</small>
                <script src="https://js.stripe.com/v3/"></script>
                <br />
                <h3>Please enter your credit card details</h3>
                <form action="/admin/writer/charge/{{$articlesAssigned->id}}" method="post" id="payment-form">
                  {{ csrf_field() }}
                    <div class="form-row">
                      <label for="card-element">
                        Credit or debit card
                      </label>
                      <div id="card-element">
                        <!-- A Stripe Element will be inserted here. -->
                      </div>

                      <!-- Used to display form errors. -->
                      <div id="card-errors" role="alert"></div>
                    </div>

                    <button class="btn btn-primary">Submit Payment</button>
                </form>
              @endif
          
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-bordered">
        <div class="panel-body">
          <h3>Messages</h3>
          @foreach($messages as $message)
            <div class="row">
              <div class="col-md-12">
                @if($role == 'Writer' && $message->sender_id == Auth::user()->id)
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
          <form role="form" class="form-edit-add" action="/admin/agents/send-message/{{$articlesAssigned->id}}" method="POST" enctype="multipart/form-data">
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

<style>
/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;

  height: 40px;

  padding: 10px 12px;

  border: 1px solid transparent;
  border-radius: 4px;
  background-color: white;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}
</style>