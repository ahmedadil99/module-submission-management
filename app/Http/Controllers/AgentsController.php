<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\ArticleToAgent;
use App\Models\WriterAgentMessages;
use Illuminate\Support\Facades\Auth;


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
        //dd($articlesAssigned);
        $user = Auth::user();
        if($user->role()->get()->first()->name == 'Writer'){
            WriterAgentMessages::create([
                'message' => $request->input('message'), 
                'writer_id' => $user->id,
                'article_id' => $articlesAssigned->article_id
            ]);
            return redirect('/admin/agents/view-article/'.$articlesAssigned->article_id);
        }
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
