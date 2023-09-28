<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Http\Requests\StoreFilesRequest;
use App\Http\Requests\UpdateFilesRequest;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Files $file)
    {
        return response()->file(storage_path('app/'.$file->file_path),['content-type'=>'application/pdf']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Files $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilesRequest $request, Files $file)
    {
        $this->authorize('update',$file);

        $data = $request->input();
        $repo = new FileRepository();
        $repo->updateStatus($file,$data);
        return redirect()->back()->with('message','Update success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Files $files)
    {
        //
    }
}
