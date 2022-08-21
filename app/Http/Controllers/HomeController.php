<?php

namespace App\Http\Controllers;

use App\Exports\LogExport;
use App\Log;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
        return view('home');
 
    } 
    public function export(Request $request)
    {  
        $From = $request->From;
        $To = $request->To;
        return Excel::download(new LogExport($From, $To), 'LogExport.xlsx');
    }
}
