<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleToAgent;
use App\Models\WriterAgentMessages;
use App\Models\ArticleNegotiation;
use Illuminate\Support\Facades\Auth;
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
        $articlesAssigned = ArticleToAgent::with('article')->where('agent_id', $id)->get();
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
        $messages = WriterAgentMessages::where('article_id', $id)->orderBy('created_at', 'DESC')->get();
        $role = Auth::user()->role()->get()->first()->name;
        return view('/vendor/voyager/agents/view-transfered-agent',
                    compact('articlesAssigned', 'messages', 'role', 'lastMessage'
        ));
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
        $user = Auth::user();
        if($user->role()->get()->first()->name == 'Writer'){
            WriterAgentMessages::create([
                'message' => $request->input('message'), 
                'writer_id' => $user->id,
                'article_id' => $articlesAssigned->article_id
            ]);

            // send email
            return redirect('/admin/agents/view-article/'.$articlesAssigned->article_id);
        }

        if($user->role()->get()->first()->name == 'Agent'){
            WriterAgentMessages::create([
                'message' => $request->input('message'), 
                'agent_id' => $user->id,
                'article_id' => $articlesAssigned->article_id
            ]);
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

    public function agentArticle($id){
        $article = ArticleToAgent::with('article')->where('id', $id)->get()->first();
        $lastMessage = $article->messages()->get()->first();
        $messages = WriterAgentMessages::where('article_id', $article->article->id)->orderBy('created_at', 'DESC')->get();
        $role = Auth::user()->role()->get()->first()->name;
        return view('/vendor/voyager/agents/agent-article', compact('article', 'messages', 'role', 'lastMessage'));
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

    public function assignArticle($agent_id, $article_id)
    {   $original_article = Article::where('id', $article_id)->firstOrFail();
        $new_article = $original_article->replicate();
        $new_article->parent_id = $original_article->id;
        $new_article->save();
        $role = Auth::user()->role()->get()->first()->name;
        $agt = ArticleToAgent::create(['article_id' => $new_article->id, 'writer_id' => $original_article->user_id, 'agent_id' => $agent_id]);
        if($role == 'Writer'){
            return redirect('/admin/agents/'.$agent_id);
        }
        else{
            return redirect('/admin/agent/view-article/'.$agt->id);
        }
       
    }
}
