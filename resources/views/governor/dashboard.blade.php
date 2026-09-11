@extends('layouts.app')
@section('title','Governor Dashboard')
@section('content')
<div class="space-y-6">
  <h1 class="text-2xl font-bold text-slate-800">Governor Assurance Dashboard</h1>
  <p class="text-slate-500">{{ $prison->name }} &mdash; {{ now()->format('d F Y') }}</p>

  <!-- Compliance overview -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-xl p-5">
      <div class="text-3xl font-black text-slate-800">{{ $absences->count() }}</div>
      <div class="text-sm text-slate-500">Active Cases</div>
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-5">
      <div class="text-3xl font-black text-red-600">{{ $overdueTriggers }}</div>
      <div class="text-sm text-slate-500">Overdue Actions</div>
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-5">
      <div class="text-3xl font-black text-amber-600">{{ $noContact }}</div>
      <div class="text-sm text-slate-500">Cases Without Contact</div>
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-5">
      @php $red = $absences->where('risk_rating','red')->count() @endphp
      <div class="text-3xl font-black {{ $red > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $red }}</div>
      <div class="text-sm text-slate-500">Red Risk Cases</div>
    </div>
  </div>

  <!-- Active cases table -->
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b"><h2 class="font-bold text-slate-800">Active Absence Cases</h2></div>
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">Staff Member</th>
          <th class="px-4 py-3 text-left">Illness</th>
          <th class="px-4 py-3 text-center">Days</th>
          <th class="px-4 py-3 text-center">Risk</th>
          <th class="px-4 py-3 text-center">Contacts</th>
          <th class="px-4 py-3 text-center">Overdue Actions</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @foreach($absences as $absence)
        <tr>
          <td class="px-4 py-3 font-medium">{{ $absence->staff->full_name }}<div class="text-xs text-slate-400">{{ $absence->staff->lineManager->name ?? 'Unassigned' }}</div></td>
          <td class="px-4 py-3">{{ $absence->illness_type_label }}</td>
          <td class="px-4 py-3 text-center font-bold">{{ $absence->duration_days }}</td>
          <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 rounded-full text-xs font-bold border {{ $absence->risk_color }}">{{ strtoupper($absence->risk_rating) }}</span></td>
          <td class="px-4 py-3 text-center">
            @if($absence->contactLogs->isEmpty()) <span class="text-red-500 font-bold">None</span>
            @else <span class="text-green-600">{{ $absence->contactLogs->count() }}</span> @endif
          </td>
          <td class="px-4 py-3 text-center">
            @php $od = $absence->triggerPoints->where('is_overdue',true)->whereNull('completed_at')->count() @endphp
            @if($od > 0) <span class="text-red-600 font-bold">{{ $od }}</span>
            @else <span class="text-green-600">None</span> @endif
          </td>
          <td class="px-4 py-3"><a href="{{ route('absences.show', $absence) }}" class="text-xs bg-slate-800 text-white px-3 py-1 rounded-lg">View</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
