<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
   public function index(){
      $my_date = date("d/m/Y:s");

      return view("page.index", compact("my_date"));
   }

   public function showUser(){
      $user = "Test User";
      return view("page.show_user", compact("user"));
   }
}
