<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $countingIncomingReport = $user->incoming_reports()->where('status','progress')->count();
        $countingAllReport = Reports::count();
        $countingAllUser = 0;
        if(auth()->user()->roles->contains('name_code','=','admin')){
            $countingAllUser = User::where('id','!=',auth()->user()->id)->count();
        }
        return view('dashboard.index',compact('countingIncomingReport','countingAllReport','countingAllUser'));
    }
}
