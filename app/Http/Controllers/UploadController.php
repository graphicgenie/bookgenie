<?php

namespace App\Http\Controllers;

use App\Http\Requests\uploadRequest;
use App\Http\Resources\uploadResource;
use App\Models\upload;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', upload::class);

        return uploadResource::collection(upload::all());
    }

    public function store(uploadRequest $request)
    {
        $this->authorize('create', Upload::class);

        return new uploadResource(upload::create($request->validated()));
    }

    public function show(Upload $upload)
    {
        $this->authorize('view', $upload);

        return new uploadResource($upload);
    }

    public function update(uploadRequest $request, Upload $upload)
    {
        $this->authorize('update', $upload);

        $upload->update($request->validated());

        return new uploadResource($upload);
    }

    public function destroy(Upload $upload)
    {
        $this->authorize('delete', $upload);

        $upload->delete();

        return response()->json();
    }

    public function download(Upload $upload)
    {
        if ($upload->user->id === auth()->user()->id) {
            return Storage::download($upload->file_name);
        }

        abort(403);
    }
}
