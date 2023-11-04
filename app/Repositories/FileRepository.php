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

            /**
             * @var \App\Models\User $user
             */

            $user = auth()->user();
            $report = $user->sent_reports()->create([
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

                if ($status === 'accepted') {
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

    public function acceptFile(Files $file)
    {
        return DB::transaction(function () use ($file) {
            # ambil data report
            $report = $file->report;
            $file->status = 'accepted';
            # cek dulu apakah file original sudah terisi atau belum
            if (!$file->file_orig) {
                $file->file_orig = $file->file_path;
            }
            $filePath = request()->file('file_path')->store('pdfs');
            $file->file_path = $filePath;
            $file->save();


            # update status report
            $report->status = 'approved';
            $report->file_id = $file->id;
            $report->save();
            return response()->json(["url" => route('report.show', ['report' => $report->slug])], 201);
        });
    }

    public function resetAcceptFile(Files $file)
    {
        return DB::transaction(function () use ($file) {
            # ambil data report
            $report = $file->report;
            $file->status = null;

            # cek dulu apakah file original sudah terisi atau belum
            $file->file_path = $file->file_orig;
            $file->save();


            # update status report
            $report->status = 'progress';
            $report->file_id = null;
            $report->save();
            return response()->json(["url" => route('report.show', ['report' => $report->slug])], 200);
        });
    }

    public function editAcceptedFile(Files $file)
    {
        return DB::transaction(function () use ($file) {
            $report = $file->report;

            # timpa dengan yang baru
            $filePath = request()->file('file_path')->store('pdfs');
            $file->file_path = $filePath;
            $file->save();

            return response()->json(["url" => route('report.show', ['report' => $report->slug])], 201);
        });
    }
}
