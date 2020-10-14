<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use TCG\Voyager\Models\Role;


class RegisterController extends Controller
{
  public function register(){
    return view('/register/create');
  }

  public function create(Request $request){
    $user = User::create(
      [
        'email' => $request->input('email'),
        'name' => $request->input('name'),
        'password' => bcrypt($request->input('password')),
        'role_id' => $request->input('role')
    ]);

    return redirect('/admin/login');
  }
}