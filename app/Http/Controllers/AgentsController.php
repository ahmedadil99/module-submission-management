<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;


class AgentsController extends Controller
{
    public function index(){
        $agents = User::with('roles')->where('name', '=', 'Agent')->get()->all();
        //return View::make("/vendor/voyager/agents/index")->with($agents);
        return view('/vendor/voyager/agents/index', compact('agents'));
    }
    public function assignArticle($agentID)
    {
        # code...
    }
}
