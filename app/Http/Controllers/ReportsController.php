<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use App\Http\Requests\StoreReportsRequest;
use App\Http\Requests\UpdateReportsRequest;
use App\Models\User;
use App\Repositories\ReportRepository;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id','!=',auth()->user()->id)->whereHas('roles',function($query){
            $query->whereIn('roles.id',[2,3]);
        })->get();
        return view('report.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportsRequest $request)
    {
        $data = $request->input();
        $repo = new ReportRepository();
        $repo->create($data);
        return redirect(route('dashboard'))->with('message','berkas berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportsRequest $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reports $reports)
    {
        //
    }
}
