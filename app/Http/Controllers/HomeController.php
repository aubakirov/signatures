<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    /*
     * Create testpage method
     *
     * @return array
     */
    public function test()
    {
        return [];
    }

    public function getCurrentYear ()
    {
        return Carbon::now()->year;
    }

    public function getCurrentMonth()
    {
        return Carbon::now()->year;
    }
}
