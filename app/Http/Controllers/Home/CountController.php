<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class CountController extends Controller
{
    public function index()
    {
        return view('home/count.count');
    }
}