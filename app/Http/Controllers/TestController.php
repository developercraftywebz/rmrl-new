<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test1()
    {
        return view('categories-insight');
    }
    public function test2()
    {
        return view('categories-photos');
    }
    public function test3()
    {
        return view('categories-insights-inner');
    }
}
