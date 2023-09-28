<?php

namespace App\Repositories;

use App\Models\Files;
use Illuminate\Support\Facades\DB;

class FileRepository
{
    public function create(array $data)
    {
        DB::transaction(function () use ($data) {
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

    public function updateStatus(Files $file, array $data)
    {
        DB::transaction(function () use ($file, $data) {
            /**
             * ketika accept akan mengapprove report juga,
             * dan menyimpan file yang di upload untuk menggantikan
             * file yang di accept
             */
            $status = $data['status'];

            $file->status = $status;
            $file->comment = $data['comment'];
            $file->save();

            if ($status !== 'revision') {
                # update status report
                $report = $file->report;
                $report->status = 'rejected';

                if($status==='accepted'){
                    $file_path = request()->file('file_path')->store('pdfs');
                    $file->file_path = $file_path;
                    $file->save();

                    # update status report
                    $report->status = 'approved';
                    $report->file_id = $file->id;
                }
                $report->save();
            }
        });
    }
}
