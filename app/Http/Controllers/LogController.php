<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $data['serial']=$request->serial;
        $data['lnner_qty']=$request->lnner_qty;
        $data['customer_qty']=$request->customer_qty;
        $data['lnner_part']=$request->lnner_part;
        $data['customer_part']=$request->customer_part;
        $data['status']=$request->status; 
        $data['user_id']=Auth::user()->id;
        Log::create($data);
    }
}
