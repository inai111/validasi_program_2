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
            $report = auth()->user()->reports()->create([
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
}