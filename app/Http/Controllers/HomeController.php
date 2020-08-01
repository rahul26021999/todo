<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasks;

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
        $closedTasks=Tasks::where('status','resolve')->get();
        $openTasks=Tasks::where('status','open')->get();
        return view('home',['closedTasks'=>$closedTasks,'openTasks'=>$openTasks]);
    }
}
