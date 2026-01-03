<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcrResult extends Model
{
    protected $fillable = [
        'document_id',
        'extracted_name',
        'extracted_nisn',
        'extracted_school',
        'extracted_year',
        'raw_text',
        'confidence_score',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
