<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Hotel Booking' }}</title>
    @vite('resources/css/app.css') <!-- or your Tailwind setup -->
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        {{ $slot }}
    </div>
</body>
</html>
