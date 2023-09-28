<?php

namespace App\Repositories;

use App\Models\Reports;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
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