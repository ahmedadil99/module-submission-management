<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleToAgent;
use App\Models\WriterAgentMessages;
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

    public function viewTransferedArticle($id)
    {
        $articlesAssigned = ArticleToAgent::with('article')->where('article_id', $id)->firstOrFail();
        $messages = WriterAgentMessages::where('article_id', $id)->orderBy('created_at', 'DESC')->get();
        $role = Auth::user()->role()->get()->first()->name;
        return view('/vendor/voyager/agents/view-transfered-agent',compact('articlesAssigned', 'messages', 'role'));
    }

    public function updateOffer($id, Request $request)
    {
        $articlesAssigned = ArticleToAgent::with('article')->where('id', $id)->firstOrFail();
        $articlesAssigned->amount_offered = $request->input('amount_offered');
        $articlesAssigned->status = 'offer_made';
        $articlesAssigned->save();
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

    public function writerCharge($id, Request $request){
        $article = ArticleToAgent::with('article')->where('id', $id)->get()->first();
        $amount = 0;
        if($article->counter_offer == null){
            $amount = $article->amount_offered;
        }
        else{
            $amount = $article->counter_offer;
        }

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create ([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
        $article->amount_paid = $amount;
        $article->status = "payment_made";
        $article->save();

        return redirect('/admin/agents/view-article/'.$article->article->id);
    }

    public function agentsArticles(){
        $myAricles = ArticleToAgent::with('article')->where('agent_id', Auth::user()->id)->get();
        return view('/vendor/voyager/agents/my-articles', compact('myAricles'));
    }

    public function agentArticle($id){
        $article = ArticleToAgent::with('article')->where('id', $id)->get()->first();
        $messages = WriterAgentMessages::where('article_id', $article->article->id)->orderBy('created_at', 'DESC')->get();
        $role = Auth::user()->role()->get()->first()->name;
        return view('/vendor/voyager/agents/agent-article', compact('article', 'messages', 'role'));
    }

    public function agentProcessOffer($id, Request $request){
        $article = ArticleToAgent::with('article')->where('id', $id)->get()->first();
        if($request->input('offer') == 'accepted'){
            $article->status = 'offer_accepted';  
        }
        if($request->input('offer') == 'rejected'){
            $article->status = 'offer_rejected';  
        }
        if($request->input('offer') == 'counter'){
            $article->status = 'counter_offer';  
        }
        if($request->input('offer') == 'reconsider_offer'){
            $article->status = 'offer_made';  
        }
        
        if($request->input('offer') == 'counter_amount'){
            $article->status = 'counter_amount_offered'; 
            $article->counter_offer = $request->input('counter_amount_offered');
        }
        $article->save();
        return redirect('/admin/agent/view-article/'.$article->id);
    }

    public function assignArticle($agent_id, $article_id)
    {   $original_article = Article::where('id', $article_id)->firstOrFail();
        $new_article = $original_article->replicate();
        $new_article->parent_id = $original_article->id;
        $new_article->save();
        $agt = ArticleToAgent::create(['article_id' => $new_article->id,'agent_id' => $agent_id]);
        return redirect('/admin/agents/'.$agent_id);
    }
}
