<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HMPPS') }} — Sign in</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">

    <!-- HMPPS Header Bar -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700 shadow-xl">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center gap-4">
            <div class="bg-white text-slate-800 font-black text-sm px-3 py-1 rounded tracking-widest flex-shrink-0">HMPPS</div>
            <div>
                <div class="text-slate-400 text-xs">Attendance Management Hub</div>
            </div>
        </div>
    </div>

    <!-- Login card -->
    <div class="flex flex-col items-center justify-center min-h-[calc(100vh-80px)] px-4 py-12">

        <!-- Logo + Title above card -->
        <div class="flex flex-col items-center mb-8">
            <div class="bg-white text-slate-800 font-black text-2xl px-6 py-3 rounded-xl shadow-lg mb-4 tracking-widest">HMPPS</div>
            <h1 class="text-white font-bold text-xl tracking-wide">Attendance Management Hub</h1>
        </div>

        <!-- Form card -->
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4">
                <h2 class="text-white font-semibold text-sm">Sign in to continue</h2>
                <p class="text-slate-400 text-xs mt-0.5">Authorised HMPPS staff only</p>
            </div>
            <div class="px-6 py-6">
                {{ $slot }}
            </div>
        </div>

        <p class="mt-6 text-slate-500 text-xs text-center">
            This system is for authorised HMPPS staff only.<br>
            Unauthorised access is a criminal offence.
        </p>
    </div>

    <!-- Footer -->
    <div class="border-t border-slate-700 py-4 text-center">
        <p class="text-slate-600 text-xs">&copy; Crown Copyright &mdash; HM Prison &amp; Probation Service</p>
    </div>

</body>
</html>
