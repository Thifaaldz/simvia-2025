<?php

namespace App\Http\Controllers\Api\OCR;

use App\Models\Document;
use App\Models\OcrResult;
use Illuminate\Http\Request;

class CallbackController
{
    public function handle(Request $request)
    {
        $doc = Document::findOrFail($request->document_id);

        $doc->update(['status' => 'review_pending']);

        OcrResult::updateOrCreate(
            ['document_id' => $doc->id],
            [
                'extracted_name' => $request->nama,
                'extracted_nisn' => $request->nisn,
                'extracted_school' => $request->sekolah,
                'extracted_year' => $request->tahun_lulus,
                'raw_text' => $request->raw_text
            ]
        );

        return response()->json(['success' => true]);
    }
}
