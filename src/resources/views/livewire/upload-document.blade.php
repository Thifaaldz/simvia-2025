<div class="max-w-lg mx-auto my-10 bg-white p-6 rounded shadow">
    @if(session('success'))
        <div class="p-3 bg-green-200 text-green-900 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <input type="text" wire:model="name" placeholder="Nama Lengkap" class="input">
        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

        <input type="text" wire:model="nisn" placeholder="NISN (10 digit)" class="input">
        @error('nisn') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

        <input type="text" wire:model="phone" placeholder="No WhatsApp (62xxxx)" class="input">
        @error('phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

        <input type="file" wire:model="file" class="input">
        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Upload
        </button>
    </form>
</div>
