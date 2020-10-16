<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleToAgent;
use App\Models\WriterAgentMessages;
use App\Models\ArticleNegotiation;
use App\Models\Conversation;
use App\Models\Messsage;
use App\Models\AgentArticle;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Stripe;


class AgentsController extends Controller
{
    public function index(){

        $agents = User::all();
        return view('/vendor/voyager/agents/index', compact('agents'));
    }
    
    public function view($id)
    {
        $agent = User::all()->where('id', $id)->first();
        $articlesAssigned = ArticleToAgent::with('article')->where('agent_id', $id)
                                                           ->where('writer_id', Auth::user()->id)
                                                           ->get();
        $ids = $articlesAssigned->pluck('article.parent_id');
        $articles = Article::all()->where('user_id', Auth::user()->id)
                                  ->where('parent_id', null)
                                  ->whereNotIn('id', $ids);
        return view('/vendor/voyager/agents/view', compact('agent', 'articles', 'articlesAssigned'));
    }
    public function viewWriters($id)
    {
        $writer = User::all()->where('id', $id)->first();
        $articlesAssigned = ArticleToAgent::with('article')->where('writer_id', $id)->get();
        $ids = $articlesAssigned->pluck('article.parent_id');
        $user = Auth::user();
        $role = Auth::user()->role()->get()->first()->name;
        $articles = Article::all()->where('user_id', $writer->id)
                                  ->where('parent_id', null)
                                  ->whereNotIn('id', $ids);
        return view('/vendor/voyager/agents/view-writer', compact('writer', 'articles', 'articlesAssigned', 'user'));
    }
    

    public function viewTransferedArticle($id)
    {
        $articlesAssigned = ArticleToAgent::with('article')->where('article_id', $id)->firstOrFail();
        $lastMessage = $articlesAssigned->messages()->get()->first();
        $messages = Conversation::where('resource_id', $articlesAssigned->id)->first()->messages()->get();
        $role = Auth::user()->role()->get()->first()->name;
        return view('/vendor/voyager/agents/view-transfered-agent',
                    compact('articlesAssigned', 'messages', 'role', 'lastMessage'
        ));
    }

    public function agentArticle($id){
        $article = ArticleToAgent::with('article')->where('id', $id)->get()->first();
        $lastMessage = $article->messages()->get()->first();
        $messages = Conversation::where('resource_id', $article->id)->first()->messages()->get();
        $role = Auth::user()->role()->get()->first()->name;
        return view('/vendor/voyager/agents/agent-article', compact('article', 'messages', 'role', 'lastMessage'));
    }

    public function inbox(){
        $conversations = Conversation::where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->get();
        return view('/vendor/voyager/agents/inbox', compact('conversations'));
    }

    public function agentProcessOffer($id, Request $request){
        $article = ArticleToAgent::with('article')->where('id', $id)->get()->first();
        $user = Auth::user();
        $role = $user->role()->get()->first()->name;
        $lastMessage = null;
        $amount = $request->input('amount_offered');
        $lastMessage = $article->messages()->orderBy('created_at', 'DESC')->get()->first();
        $amount = $request->input('amount_offered') == null ? $lastMessage->amount : $request->input('amount_offered');
        ArticleNegotiation::create([
             'message' => $request->input('message'), 
             'article_to_agent_id' => $article->id,
             'agent_id' => $user->id,
             'amount' => $amount,
             'status' => $request->input('status')
        ]);
        return redirect('/admin/agent/view-article/'.$article->id);
    }

    public function updateOffer($id, Request $request)
    {
        $articlesAssigned = ArticleToAgent::with('article')->where('id', $id)->firstOrFail();
        $user = Auth::user();
        $role = $user->role()->get()->first()->name;
        $lastMessage = null;
        $amount = $request->input('amount_offered');
        $lastMessage = $articlesAssigned->messages()->orderBy('created_at', 'DESC')->get()->first();
        $amount = $request->input('amount_offered') == null ? $lastMessage->amount : $request->input('amount_offered');

        if($role == 'Writer'){            
            ArticleNegotiation::create([
                'message' => $request->input('message'), 
                'article_to_agent_id' => $articlesAssigned->id,
                'writer_id' => $user->id,
                'amount' => $amount,
                'status' => $request->input('status')
            ]);
        }
        else{

        }
        return redirect('/admin/agents/view-article/'.$articlesAssigned->article_id);
    }

    public function sendMessage($id, Request $request)
    {
        $articlesAssigned = ArticleToAgent::with('article')->where('id', $id)->firstOrFail();
        $conversation = Conversation::where('resource_id', $articlesAssigned->id)->first();
        $user = Auth::user();
        $email = '';
        $from_name = Auth::user()->name;
        if($user->role()->get()->first()->name == 'Writer'){
            Messsage::create([
                'conversation_id' => $conversation->id, 
                'message' => $request->input('message'), 
                'sender_id' => $articlesAssigned->writer_id,
                'receiver_id' => $articlesAssigned->agent_id
            ]);

            $email = User::where('id', $articlesAssigned->agent_id)->first()->email;
            $data = ['message' => $request->input('message'), 'to' => $email, 'from_name' => $from_name];
            Mail::send(new SendEmail($data));
            return redirect('/admin/agents/view-article/'.$articlesAssigned->article_id);
        }

        if($user->role()->get()->first()->name == 'Agent'){
            Messsage::create([
                'conversation_id' => $conversation->id, 
                'message' => $request->input('message'), 
                'receiver_id' => $articlesAssigned->writer_id,
                'sender_id' => $articlesAssigned->agent_id
            ]);

            $email = User::where('id', $articlesAssigned->writer_id)->first()->email;
            $data = ['message' => $request->input('message'), 'to' => $email, 'from_name' => $from_name];
            Mail::send(new SendEmail($data));
            return redirect('/admin/agent/view-article/'.$articlesAssigned->id);
        }
    }

    public function agentWriterList(){
       $writers = User::all();
       return view('/vendor/voyager/agents/writers-index', compact('writers'));
    }

    public function writerCharge($id, Request $request){
        $article = ArticleToAgent::with('article')->where('id', $id)->get()->first();
        $user = Auth::user();
        $amount = 0;
        $lastMessage = $article->messages()->where('status','=', 'offer_accepted')
                                           ->orderBy('created_at', 'DESC')
                                           ->get()->first();
        $amount = intval($lastMessage->amount);

        

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" =>  $amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);

        ArticleNegotiation::create([
            'message' => 'payment has been made', 
            'article_to_agent_id' => $article->id,
            'writer_id' => $user->id,
            'amount' => $amount,
            'status' => 'article_transfered'
        ]);

        return redirect('/admin/agents/view-article/'.$article->article->id);
    }

    public function agentsArticles(){
        $myAricles = ArticleToAgent::with('article')->where('agent_id', Auth::user()->id)->get();
        return view('/vendor/voyager/agents/my-articles', compact('myAricles'));
    }

    public function agentPublisherChat($agent_id, $publisher_id, Request $request){
        $conversation = Conversation::where('sender_id', $agent_id)->where('receiver_id', $publisher_id)->first();
        $role = Auth::user()->role()->get()->first()->name;
        $email = '';
        $from_name = Auth::user()->name;
        if($conversation == null){
            $conversation = Conversation::create(['sender_id' => $agent_id, 'receiver_id' => $publisher_id]);
        }
        if($request->input('message')){
            if($role == 'Agent'){
                Messsage::create(['conversation_id' => $conversation->id, 
                                  'sender_id' => $agent_id,
                                  'receiver_id' => $publisher_id,
                                  'message' => $request->input('message')
                                  ]);
                $email = User::where('id', $publisher_id)->first()->email;
                
                
            }
            else{
                Messsage::create(['conversation_id' => $conversation->id,
                                  'sender_id' => $publisher_id,
                                  'receiver_id' => $agent_id,
                                  'message' => $request->input('message')
                                  ]);
                $email = User::where('id', $agent_id)->first()->email;
            }
            $data = ['message' => $request->input('message'), 'to' => $email, 'from_name' => $from_name];
            Mail::send(new SendEmail($data));
        }
        
        

        


        $messages = Messsage::where('conversation_id', $conversation->id)->orderBy('created_at', 'DESC')->get();
        return view('/vendor/voyager/agents/agent-publisher-chat', compact('conversation', 'messages', 'agent_id', 'publisher_id', 'role'));
    }

    public function publisherArticles(Request $request){
        $articles = AgentArticle::where('publisher_id', Auth::user()->id)->get();
        if($request->input('article_id')){
            $article = Article::where('id', $request->input('article_id'))->first();
            return view('/vendor/voyager/agents/publisher-my-article-view', compact('article'));
        }
        else{
            return view('/vendor/voyager/agents/publisher-my-articles', compact('articles'));
        }        
    }

    public function publisherAgentsList(Request $request){
        $agents = User::where('role_id', 4)->get();
        return view('/vendor/voyager/agents/agents-index', compact('agents'));
    }

    public function agentShareArticle($id, Request $request){
       $publishers = User::where('role_id', 5)->get();
       $article_id = $id;
       if($request->input('publisher_id')){
        
        $articlePublisher = AgentArticle::where('publisher_id', $request->input('publisher_id'))->where('article_id', $id)->first();
        if($articlePublisher == null){
            AgentArticle::create(['publisher_id' => $request->input('publisher_id'), 'article_id' => $id, 'agent_id' => Auth::user()->id]);
        }
        return redirect('/admin/agent/share-article/'.$id);
       }
       else{
        return view('/vendor/voyager/agents/publishers-index', compact('publishers', 'article_id'));
       }
       
    }

    

    
    public function assignArticle($agent_id, $article_id)
    {   $original_article = Article::where('id', $article_id)->firstOrFail();
        $new_article = $original_article->replicate();
        $new_article->parent_id = $original_article->id;
        $new_article->save();
        $role = Auth::user()->role()->get()->first()->name;
        $agt = ArticleToAgent::create(['article_id' => $new_article->id, 'writer_id' => $original_article->user_id, 'agent_id' => $agent_id]);
        Conversation::create(['resource_id' => $agt->id, 'sender_id' => $original_article->user_id, 'receiver_id' => $agent_id]);
        if($role == 'Writer'){
            return redirect('/admin/agents/'.$agent_id);
        }
        else{
            return redirect('/admin/agent/view-article/'.$agt->id);
        }
       
    }
}
