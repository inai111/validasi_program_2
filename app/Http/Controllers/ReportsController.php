<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilesRequest;
use App\Models\Reports;
use App\Http\Requests\StoreReportsRequest;
use App\Http\Requests\UpdateReportsRequest;
use App\Models\User;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAnyReport',Reports::class);
        $title = 'All Report';

        $repo = new ReportRepository();
        $reports = $repo->all();

        return view('report.index', compact('reports','title'));
    }
    public function sent()
    {
        $this->authorize('viewAnyReport',Reports::class);
        $title = 'Sent Report';

        $user = auth()->user();

        $repo = new ReportRepository();
        $reports = $repo->sent($user);
        
        return view('report.sent', compact('reports','title'));
    }
    public function incoming()
    {
        $this->authorize('viewIncomingReport');
        $title = 'Incoming Report';

        $user = auth()->user();

        $repo = new ReportRepository();
        $reports = $repo->incoming($user);

        return view('report.incoming', compact('reports', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('createReport',Reports::class);
        $title = 'Create Report';

        $users = User::where('id', '!=', auth()->user()->id)->whereHas('roles', function ($query) {
            $query->whereIn('roles.id', [2, 3]);
        })->get();

        return view('report.create', compact('users','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportsRequest $request)
    {
        $data = $request->input();
        $repo = new ReportRepository();
        $repo->create($data);
        return redirect(route('report.sent'))->with('message', 'berkas berhasil disimpan');
    }
    public function addfile(StoreFilesRequest $request,Reports $report)
    {
        $this->authorize('update',$report);
        $data = $request->input();
        $repo = new ReportRepository();
        $repo->addFile($report,$data);
        return redirect()->back()->with('message', 'new file added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reports $report)
    {
        $this->authorize('viewAnyReport',Reports::class);
        $title = 'Detail Report';

        return view('report.detail', compact('report','title'));
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
    public function update(UpdateReportsRequest $request,Reports $report)
    {
        $repo = new ReportRepository();
        $repo->updateStatus($report, $request->input('status'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reports $report)
    {
        $this->authorize('delete',$report);

        $report->delete();
        return redirect()->back()->with('message','Report deleted');
    }
}
