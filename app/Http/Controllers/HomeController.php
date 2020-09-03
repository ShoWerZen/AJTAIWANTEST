<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $fortune = DB::table("fortune")
                        ->select("fortune.*", "astro.*")
                        ->leftJoin("astro", "fortune.astro_id", "=", "astro.id")
                        ->where("fortune.dailyDate" , "=", date("Y-m-d"))
                        ->get();
            return view('home', ["fortune" => $fortune]);
        }
        else
            return view('home');
    }
}
