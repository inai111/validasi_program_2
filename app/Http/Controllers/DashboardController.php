<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $reportRepo = new ReportRepository();
        $reports = $reportRepo->all();
        $reportsIncoming = $reportRepo->incomingProgress($user);
        
        $userRepo = new UserRepository();
        $users = $userRepo->all();

        $roles = Roles::all();

        return view('dashboard.index',compact('roles','users','reports','reportsIncoming'));
    }
}
