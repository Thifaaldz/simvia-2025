<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Ijazah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">

    <div class="min-h-screen py-10">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
    