@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-6">
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold text-slate-800">Manager Dashboard</h1>
    <a href="{{ route('absences.create') }}" class="bg-gradient-to-r from-slate-700 to-slate-900 text-white px-4 py-2 rounded-xl shadow-lg hover:shadow-xl transition-all text-sm font-medium">+ Log Absence</a>
  </div>

  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-xl p-5 border border-gray-100">
      <div class="text-3xl font-black text-slate-800">{{ $stats['active'] }}</div>
      <div class="text-sm text-slate-500 mt-1">Currently Absent</div>
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-5 bg-gradient-to-br from-white to-amber-50">
      <div class="text-3xl font-black text-amber-600">{{ $stats['due_today'] }}</div>
      <div class="text-sm text-slate-500 mt-1">Actions Due Today</div>
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-5 bg-gradient-to-br from-white to-red-50">
      <div class="text-3xl font-black text-red-600">{{ $stats['overdue'] }}</div>
      <div class="text-sm text-slate-500 mt-1">Overdue Actions</div>
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-5">
      <div class="flex gap-2 items-end">
        <span class="text-xl font-black text-red-500">{{ $stats['red'] }}</span>
        <span class="text-xl font-black text-amber-500">{{ $stats['amber'] }}</span>
        <span class="text-xl font-black text-green-500">{{ $stats['green'] }}</span>
      </div>
      <div class="text-sm text-slate-500 mt-1">Risk R / A / G</div>
    </div>
  </div>

  @if($overdueTriggers->count())
  <div class="bg-red-50 border border-red-200 rounded-2xl p-4">
    <h2 class="font-bold text-red-800 mb-3">{{ $overdueTriggers->count() }} Overdue Action(s)</h2>
    @foreach($overdueTriggers->take(5) as $trigger)
    <div class="flex items-center justify-between bg-white rounded-xl px-4 py-2 shadow-sm mb-2">
      <span class="text-sm font-medium">{{ $trigger->absence->staff->full_name ?? 'Unknown' }}</span>
      <span class="text-sm text-red-600">{{ $trigger->label }} &mdash; due {{ $trigger->action_due_date->diffForHumans() }}</span>
      <a href="{{ route('absences.show', $trigger->absence_id) }}" class="text-xs bg-red-600 text-white px-3 py-1 rounded-lg">View</a>
    </div>
    @endforeach
  </div>
  @endif

  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between">
      <h2 class="font-bold text-slate-800">Currently Absent Staff</h2>
      <a href="{{ route('daily-sick-list') }}" class="text-sm text-slate-500 hover:text-slate-700">View Sick List &rarr;</a>
    </div>
    @if($activeAbsences->isEmpty())
      <div class="px-6 py-12 text-center text-slate-400">No active absences.</div>
    @else
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">Staff Member</th>
          <th class="px-4 py-3 text-left">Illness</th>
          <th class="px-4 py-3 text-center">Days</th>
          <th class="px-4 py-3 text-center">Risk</th>
          <th class="px-4 py-3 text-left">Next Action</th>
          <th class="px-4 py-3 text-left">Last Contact</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @foreach($activeAbsences as DVArabsence)
        <tr class="hover:bg-slate-50">
          <td class="px-4 py-3 font-medium">
            <a href="{{ route('staff.show', DVArabsence->staff_id) }}">{{ DVArabsence->staff->full_name }}</a>
            <div class="text-xs text-slate-400">{{ DVArabsence->staff->department }} &middot; {{ DVArabsence->staff->band }}</div>
          </td>
          <td class="px-4 py-3 text-slate-600">{{ DVArabsence->illness_type_label }}</td>
          <td class="px-4 py-3 text-center font-bold">{{ DVArabsence->duration_days }}</td>
          <td class="px-4 py-3 text-center">
            <span class="px-2 py-1 rounded-full text-xs font-bold border {{ DVArabsence->risk_color }}">{{ strtoupper(DVArabsence->risk_rating) }}</span>
          </td>
          <td class="px-4 py-3 text-xs">
            @php $next = DVArabsence->triggerPoints->whereNull('completed_at')->sortBy('action_due_date')->first() @endphp
            @if($next)
              <span class="{{ $next->is_overdue ? 'text-red-600 font-bold' : 'text-slate-500' }}">{{ $next->label }}<br>{{ $next->action_due_date->format('d M') }}</span>
            @else <span class="text-green-600">None due</span> @endif
          </td>
          <td class="px-4 py-3 text-xs text-slate-500">
            @if(DVArabsence->contactLogs->isNotEmpty())
              {{ DVArabsence->contactLogs->sortByDesc('contacted_at')->first()->contacted_at->diffForHumans() }}
            @else <span class="text-amber-600 font-medium">No contact logged</span> @endif
          </td>
          <td class="px-4 py-3"><a href="{{ route('absences.show', DVArabsence) }}" class="text-xs bg-slate-800 text-white px-3 py-1 rounded-lg">View</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@endsection
