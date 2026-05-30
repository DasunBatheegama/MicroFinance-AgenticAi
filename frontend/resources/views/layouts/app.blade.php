<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MicroFinance - Registration</title>
    
    <!-- Tailwind CSS (Using CDN for quick local testing) -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    <main class="py-10">
        <!-- This is where the Livewire component will be injected -->
        {{ $slot }}
    </main>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
