<?php

namespace App\Repositories;

use App\Models\Reports;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
    public function all()
    {
        $reports = Reports::orderByRaw("
        CASE
            WHEN status = 'approved' THEN 1
            WHEN status = 'progress' THEN 2
            WHEN status = 'rejected' THEN 3
            WHEN status = 'canceled' THEN 4
            ELSE 5
        END
        ");
        return QueryBuilder::for($reports)
            ->allowedFilters('subject', 'status', 'created_at')
            ->allowedSorts('created_at', 'subject', 'status')
            ->paginate(15)->appends(request()->query());
    }

    public function incoming(User $user)
    {
        return QueryBuilder::for($user->incoming_reports())
            ->allowedFilters('subject', 'status', 'created_at')
            ->allowedSorts('created_at', 'subject', 'status')
            ->paginate(15)->appends(request()->query());
    }

    public function incomingProgress(User $user)
    {
        $reports = $user->incoming_reports()->where('status','progress');
        return QueryBuilder::for($reports)
            ->allowedFilters('subject', 'status', 'created_at')
            ->allowedSorts('created_at', 'subject', 'status')
            ->paginate(15)->appends(request()->query());
    }

    public function sent(User $user)
    {
        return QueryBuilder::for($user->sent_reports())
            ->allowedFilters('subject', 'status', 'created_at')
            ->allowedSorts('created_at', 'subject', 'status')
            ->paginate(15)->appends(request()->query());
    }

    public function create(array $data)
    {
        DB::transaction(function()use($data){
            $request = request();
            $report = auth()->user()->sent_reports()->create([
                'subject' => $data['subject'],
                'target_id' => $data['target_id'],
            ]);

            $filePath = $request->file('file')->store('pdfs');

            $report->files()->create([
                'description' => $data['description'],
                'file_path' => $filePath,
                'file_orig' => $filePath,
            ]);
        });
    }

    public function addFile(Reports $report, array $data)
    {
        DB::transaction(function()use($report,$data){
            $file = $report->files->last();
            $file->status = 'rejected';
            $file->save();

            $filePath = request()->file('file_path')->store('pdfs');

            $report->files()->create([
                'description' => $data['description'],
                'file_path' => $filePath,
            ]);
        });
    }

    public function updateStatus(Reports $report, string $status)
    {
        DB::transaction(function()use($report,$status){
            switch($status){
                case 'canceled':
                case 'rejected':
                    $fileStatus = 'rejected';
                    break;
                default:
                    $fileStatus = 'accepted';
                    break;
            }
            $report->status = $status;
            $report->save();
            

            $file = $report->files->last();
            $file->status = $fileStatus;
            $file->save();

            if($status=='approved'){
                $filePath = request()->file('file')->store('pdfs');

                $report->files()->create([
                    'comment' => request()->input('comment'),
                    'file_path' => $filePath,
                ]);
            }
        });
    }
}