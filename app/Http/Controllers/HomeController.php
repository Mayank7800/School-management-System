<?php

namespace App\Http\Controllers;



class HomeController extends Controller
{
    public function create()
    {
        return view('home');
    }
}