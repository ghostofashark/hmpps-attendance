<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-gray-50">

<nav class="bg-gradient-to-r from-slate-800 to-slate-900 shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/hmpps-logo.png') }}"
                     alt="HM Prison &amp; Probation Service"
                     class="h-8 w-auto bg-white px-2 py-0.5 rounded flex-shrink-0">
                <div>
                    <div class="text-slate-300 text-xs">Attendance Management Hub</div>
                </div>
            </div>
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('dashboard') }}" class="text-slate-300 hover:text-white hover:bg-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-all">Dashboard</a>
                <a href="{{ route('daily-sick-list') }}" class="text-slate-300 hover:text-white hover:bg-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-all">Sick List</a>
                <a href="{{ route('staff.index') }}" class="text-slate-300 hover:text-white hover:bg-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-all">Staff</a>
                <a href="{{ route('absences.index') }}" class="text-slate-300 hover:text-white hover:bg-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-all">Absences</a>
                @if(auth()->user()->hasRole(['governor','hobba']))
                <a href="{{ route('governor.dashboard') }}" class="text-slate-300 hover:text-white hover:bg-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-all">Governor</a>
                @endif
                <a href="{{ route('statistics') }}" class="text-slate-300 hover:text-white hover:bg-slate-700 px-3 py-2 rounded-lg text-sm font-medium transition-all">Statistics</a>
                @if(auth()->user()->hasRole('hobba'))
                <a href="{{ route('admin.authorised-viewers.index') }}" class="text-slate-300 hover:text-white hover:bg-amber-700 px-3 py-2 rounded-lg text-sm font-medium transition-all">
                    Admin
                </a>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <span class="text-slate-400 text-xs">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-slate-400 hover:text-white text-xs px-3 py-1 border border-slate-600 rounded-lg hover:border-slate-400 transition-all">Sign out</button>
                </form>
            </div>
        </div>
    </div>
</nav>

@auth
<div class="bg-gradient-to-r from-slate-700 to-slate-800 border-b border-slate-600">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between">
        <div class="flex items-center gap-2 text-xs text-slate-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>
            @if(auth()->user()->prison)
                <span class="font-medium text-white">{{ auth()->user()->prison->name }}</span>
                <span class="text-slate-400">{{ auth()->user()->prison->category_label }}</span>
            @else
                <span class="text-slate-400">No prison assigned</span>
            @endif
            @if(auth()->user()->hasRole('hobba'))
                <span class="ml-3 bg-amber-600 text-white px-2 py-0.5 rounded-full text-xs font-bold">HOBBA</span>
            @elseif(auth()->user()->hasRole('governor'))
                <span class="ml-3 bg-blue-600 text-white px-2 py-0.5 rounded-full text-xs font-bold">Governor</span>
            @endif
        </div>
        <div class="text-xs text-slate-400">{{ now()->format('l, d F Y') }}</div>
    </div>
</div>
@endauth

<div class="max-w-7xl mx-auto px-4 pt-4">
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-4">{{ session('error') }}</div>
    @endif
</div>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    @yield('content')
</main>

<footer class="bg-slate-800 mt-12 border-t border-slate-700">
    <div class="max-w-7xl mx-auto px-4 py-4">
        <div class="flex flex-wrap gap-4 text-xs text-slate-400 justify-center">
            <span class="font-medium text-slate-300">HMPPS</span>
            <span>|</span><span>Prison Service</span>
            <span>|</span><span>Probation Service</span>
            <span>|</span><span>Youth Custody Service</span>
        </div>
    </div>
</footer>

@livewireScripts
</body>
</html>
