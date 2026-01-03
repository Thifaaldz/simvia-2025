<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Document extends Model
{
      protected $fillable = [
        'name',
        'nisn',
        'phone',
        'file_path',
        'status',
        'rejection_reason',
    ];

    public function ocrResult(): HasOne
    {
        return $this->hasOne(OcrResult::class);
    }
}
