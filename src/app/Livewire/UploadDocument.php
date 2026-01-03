<?php

namespace App\Livewire;

use Livewire\WithFileUploads;
use App\Models\Document;
use Livewire\Component;

class UploadDocument extends Component
{
use WithFileUploads;

    public $name;
    public $nisn;
    public $phone;
    public $file;

    protected $rules = [
        'name' => 'required|string|max:255',
        'nisn' => 'required|digits:10',
        'phone' => 'required|string|max:20|regex:/^62[0-9]+$/',
        'file' => 'required|mimes:pdf|max:4096'
    ];

    public function submit()
    {
        $this->validate();

        $filePath = $this->file->store('documents','public');

        $document = Document::create([
            'name' => $this->name,
            'nisn' => $this->nisn,
            'phone' => $this->phone,
            'file_path' => $filePath,
            'status' => 'uploaded',
        ]);

        // === CALL n8n Webhook Here ===
        $this->triggerOcr($document->id);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah!');
    }

    private function triggerOcr($documentId)
    {
        $url = config('services.n8n.webhook_url');

        @file_get_contents($url . '?document_id=' . $documentId);
    }

    public function render()
    {
        return view('livewire.upload-document');
    }
}
