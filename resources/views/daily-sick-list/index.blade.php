@extends('layouts.app')
@section('title','Daily Sick List')
@section('content')
<div class="space-y-4">
  <div class="flex justify-between items-center">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Daily Sick List</h1>
      <p class="text-slate-500 text-sm">{{ now()->format('l, d F Y') }}</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('daily-sick-list.export') }}" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-slate-700">Export PDF</a>
      <a href="{{ route('absences.create') }}" class="border border-slate-300 text-slate-700 px-4 py-2 rounded-xl text-sm">+ Log Absence</a>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b bg-slate-50 flex items-center justify-between">
      <span class="text-sm font-medium text-slate-600">{{ $absences->count() }} staff currently absent</span>
      <span class="text-xs text-slate-400">Toggle to include/exclude from printed list</span>
    </div>
    @if($absences->isEmpty())
      <div class="px-6 py-16 text-center">
        <div class="text-4xl mb-3">✓</div>
        <p class="text-slate-600 font-medium">No absences recorded today</p>
      </div>
    @else
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">Staff Member</th>
          <th class="px-4 py-3 text-left">Payroll</th>
          <th class="px-4 py-3 text-left">Dept / Band</th>
          <th class="px-4 py-3 text-left">Illness</th>
          <th class="px-4 py-3 text-center">Days</th>
          <th class="px-4 py-3 text-center">Risk</th>
          <th class="px-4 py-3 text-left">Started</th>
          <th class="px-4 py-3 text-center">In List</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @foreach($absences->sortBy('staff.last_name') as DVArabsence)
        <tr class="hover:bg-slate-50 {{ !DVArabsence->include_in_daily_list ? 'opacity-50' : '' }}">
          <td class="px-4 py-3 font-medium">{{ DVArabsence->staff->full_name }}</td>
          <td class="px-4 py-3 text-slate-400 text-xs">{{ DVArabsence->staff->payroll_number }}</td>
          <td class="px-4 py-3 text-slate-500">{{ DVArabsence->staff->department }}<br><span class="text-xs">{{ DVArabsence->staff->band }}</span></td>
          <td class="px-4 py-3">{{ DVArabsence->illness_type_label }}</td>
          <td class="px-4 py-3 text-center font-bold">{{ DVArabsence->duration_days }}</td>
          <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 rounded-full text-xs font-bold border {{ DVArabsence->risk_color }}">{{ strtoupper(DVArabsence->risk_rating) }}</span></td>
          <td class="px-4 py-3 text-slate-500">{{ DVArabsence->start_date->format('d M') }}</td>
          <td class="px-4 py-3 text-center">
            <form method="POST" action="{{ route('absences.toggle-daily-list', DVArabsence) }}">
              @csrf
              <button type="submit" class="w-8 h-8 rounded-full border-2 transition-all {{ DVArabsence->include_in_daily_list ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 text-gray-300' }}">{{ DVArabsence->include_in_daily_list ? '✓' : '○' }}</button>
            </form>
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
