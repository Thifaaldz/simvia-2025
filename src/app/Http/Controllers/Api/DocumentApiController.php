<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;

class DocumentApiController
{
    public function show($id)
    {
        $document = Document::findOrFail($id);

        return response()->json([
            'id' => $document->id,
            'name' => $document->name,
            'nisn' => $document->nisn,
            'phone' => $document->phone,
            'file_path' => $document->file_path,
            'status' => $document->status
        ]);
    }
}
