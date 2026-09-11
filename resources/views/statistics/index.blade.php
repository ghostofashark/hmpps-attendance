@extends('layouts.app')
@section('title','Statistics')
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-slate-800">Absence Statistics</h1>
    <div class="flex gap-2">
      <a href="?scope=local" class="px-3 py-1.5 rounded-xl text-sm {{ $scope=='local' ? 'bg-slate-800 text-white' : 'border border-gray-300 text-slate-600' }}">Local</a>
      <a href="?scope=national" class="px-3 py-1.5 rounded-xl text-sm {{ $scope=='national' ? 'bg-slate-800 text-white' : 'border border-gray-300 text-slate-600' }}">National</a>
    </div>
  </div>

  <!-- By illness type -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-xl p-6">
      <h2 class="font-bold text-slate-700 mb-4">By Illness Type</h2>
      @php $max = $byIllness->max('total') ?: 1 @endphp
      @foreach($byIllness as $row)
      <div class="mb-3">
        <div class="flex justify-between text-sm mb-1">
          <span>{{ ucfirst(str_replace('_',' ',$row->illness_type)) }}</span>
          <span class="font-bold">{{ $row->total }}</span>
        </div>
        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
          <div class="h-full bg-gradient-to-r from-slate-700 to-slate-900 rounded-full" style="width: {{ round(($row->total/$max)*100) }}%"></div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- By Prison -->
    <div class="bg-white rounded-2xl shadow-xl p-6">
      <h2 class="font-bold text-slate-700 mb-4">Active Absences by Prison</h2>
      @foreach($byPrison->sortByDesc('active_count') as $prison)
      <div class="flex justify-between items-center py-2 border-b border-gray-50">
        <div>
          <p class="text-sm font-medium">{{ $prison->name }}</p>
          <p class="text-xs text-slate-400">{{ $prison->code }} &middot; Cat {{ $prison->category }}</p>
        </div>
        <span class="text-xl font-black {{ $prison->active_count > 5 ? 'text-red-600' : 'text-slate-700' }}">{{ $prison->active_count }}</span>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Monthly trend -->
  <div class="bg-white rounded-2xl shadow-xl p-6">
    <h2 class="font-bold text-slate-700 mb-4">Monthly Trend</h2>
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-xs uppercase text-slate-500">
        <tr><th class="px-4 py-2 text-left">Month</th><th class="px-4 py-2 text-right">New Absences</th></tr>
      </thead>
      <tbody>
        @foreach($monthly as $row)
        <tr class="border-b border-gray-50">
          <td class="px-4 py-2">{{ $row->month }}</td>
          <td class="px-4 py-2 text-right font-bold">{{ $row->total }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
