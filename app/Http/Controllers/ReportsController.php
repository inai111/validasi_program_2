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
        $this->authorize('viewAny',Reports::class);
        $users = auth()->user();
        $reports = Reports::orderByRaw("
        CASE
            WHEN status = 'approved' THEN 1
            WHEN status = 'progress' THEN 2
            WHEN status = 'rejected' THEN 3
            WHEN status = 'canceled' THEN 4
            ELSE 5
        END
        ");
        $reports = QueryBuilder::for($reports)
            ->allowedFilters('subject', 'status', 'created_at')
            ->allowedSorts('created_at', 'subject', 'status')
            ->get();
        $title = 'All Report';
        return view('report.index', compact('reports'));
    }
    public function sent()
    {
        $this->authorize('viewAny',Reports::class);
        $users = auth()->user();
        $reports = $users->sent_reports()->orderByRaw("
        CASE
            WHEN status = 'progress' THEN 1
            WHEN status = 'approved' THEN 2
            WHEN status = 'rejected' THEN 3
            WHEN status = 'canceled' THEN 4
            ELSE 5
        END
        ");
        $reports = QueryBuilder::for($reports)
            ->allowedFilters('subject', 'status', 'created_at')
            ->allowedSorts('created_at', 'subject', 'status')
            ->get();
        $title = 'Sent Report';
        return view('report.sent', compact('reports'));
    }
    public function incoming()
    {
        $this->authorize('viewAny',Reports::class);

        $users = auth()->user();
        $reports = $users->incoming_reports()->orderByRaw("
        CASE
            WHEN status = 'progress' THEN 1
            WHEN status = 'approved' THEN 2
            WHEN status = 'rejected' THEN 3
            WHEN status = 'canceled' THEN 4
            ELSE 5
        END
        ");
        $reports = QueryBuilder::for($reports)
            ->allowedFilters('subject', 'status', 'created_at')
            ->allowedSorts('created_at', 'subject', 'status')
            ->get();
        $title = 'Incoming Report';
        return view('report.incoming', compact('reports', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '!=', auth()->user()->id)->whereHas('roles', function ($query) {
            $query->whereIn('roles.id', [2, 3]);
        })->get();
        return view('report.create', compact('users'));
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
        return view('report.detail', compact('report'));
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
