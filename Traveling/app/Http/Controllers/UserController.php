<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\flight;

class UserController extends Controller
{
    function index(){
        if(Auth::check()&& Auth::user()->usertype=='user'){
            return view('dashboard');
        }
        
        else if(Auth::check()&& Auth::user()->usertype=='admin'){
            return view('admin.dashboard');
        }
    }

    function home(){
        $flights = flight::limit(4)->get();
        return view('index', compact('flights'));
    }
}
