<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use TCG\Voyager\Models\Role; 

class RegisterController extends Controller
{

  public function create()
  {
    return view('register.create');
  }

  public function store(){
    $this->validate(request(), [
      'name' => 'required',
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'role' => ['required', Rule::in(['Writer', 'Publisher', 'Agent'])],
    ]);
    
    $role = Role::where('name', request()->input('role'))->first();
    $user = User::create(request(['name', 'email', 'password']));
    $user->role_id = $role->id;
    $user->save();
    auth()->login($user);        
    return redirect()->to('/admin/login');
  }
}