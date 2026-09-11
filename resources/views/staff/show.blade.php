@extends('layouts.app')
@section('title', $staff->full_name)
@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-start">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">{{ $staff->full_name }}</h1>
      <p class="text-slate-500">{{ $staff->job_title }} &middot; {{ $staff->department }} &middot; {{ $staff->band }} &middot; {{ $staff->prison->name }}</p>
    </div>
    <div class="flex gap-2">
      <a href="{{ route('absences.create') }}?staff_id={{ $staff->id }}" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm font-medium">Log Absence</a>
      <a href="{{ route('staff.edit', $staff) }}" class="border border-slate-300 text-slate-700 px-4 py-2 rounded-xl text-sm">Edit</a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-xl p-6">
      <h2 class="font-bold text-slate-700 mb-4">Contact Details</h2>
      <dl class="space-y-2 text-sm">
        <div class="flex gap-2"><dt class="text-slate-400 w-32">Payroll</dt><dd>{{ $staff->payroll_number }}</dd></div>
        <div class="flex gap-2"><dt class="text-slate-400 w-32">Phone</dt><dd>{{ $staff->phone ?? 'Not recorded' }}</dd></div>
        <div class="flex gap-2"><dt class="text-slate-400 w-32">Mobile</dt><dd>{{ $staff->mobile ?? 'Not recorded' }}</dd></div>
        <div class="flex gap-2"><dt class="text-slate-400 w-32">Email</dt><dd>{{ $staff->email ?? 'Not recorded' }}</dd></div>
        <div class="flex gap-2"><dt class="text-slate-400 w-32">Address</dt><dd class="whitespace-pre-wrap">{{ $staff->home_address ?? 'Not recorded' }}</dd></div>
        <div class="flex gap-2"><dt class="text-slate-400 w-32">Next of Kin</dt><dd>{{ $staff->next_of_kin_name ?? 'Not recorded' }}</dd></div>
        <div class="flex gap-2"><dt class="text-slate-400 w-32">Line Manager</dt><dd>{{ $staff->lineManager->name ?? 'Not assigned' }}</dd></div>
      </dl>
    </div>
    <div class="bg-white rounded-2xl shadow-xl p-6">
      <h2 class="font-bold text-slate-700 mb-4">Absence Summary</h2>
      <div class="space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-slate-400">Total absences (this year)</span><span class="font-bold">{{ $staff->absenceRecords()->whereYear('start_date', now()->year)->count() }}</span></div>
        <div class="flex justify-between"><span class="text-slate-400">Bradford Score</span><span class="font-bold text-{{ $staff->bradford_score > 100 ? 'red' : ($staff->bradford_score > 50 ? 'amber' : 'green') }}-600">{{ $staff->bradford_score }}</span></div>
        <div class="flex justify-between"><span class="text-slate-400">Currently absent</span><span class="font-bold">{{ $staff->activeAbsences->count() > 0 ? 'Yes' : 'No' }}</span></div>
      </div>
    </div>
  </div>

  <!-- Absence history -->
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b"><h2 class="font-bold text-slate-800">Absence History</h2></div>
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">Start</th>
          <th class="px-4 py-3 text-left">End</th>
          <th class="px-4 py-3 text-left">Illness</th>
          <th class="px-4 py-3 text-center">Days</th>
          <th class="px-4 py-3 text-center">Risk</th>
          <th class="px-4 py-3 text-left">Status</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($staff->absenceRecords->sortByDesc('start_date') as DVArabsence)
        <tr>
          <td class="px-4 py-3">{{ DVArabsence->start_date->format('d M Y') }}</td>
          <td class="px-4 py-3">{{ DVArabsence->end_date?->format('d M Y') ?? 'Ongoing' }}</td>
          <td class="px-4 py-3">{{ DVArabsence->illness_type_label }}</td>
          <td class="px-4 py-3 text-center font-bold">{{ DVArabsence->duration_days }}</td>
          <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 rounded-full text-xs font-bold border {{ DVArabsence->risk_color }}">{{ strtoupper(DVArabsence->risk_rating) }}</span></td>
          <td class="px-4 py-3">{{ ucfirst(str_replace('_',' ',DVArabsence->status)) }}</td>
          <td class="px-4 py-3"><a href="{{ route('absences.show', DVArabsence) }}" class="text-xs bg-slate-800 text-white px-3 py-1 rounded-lg">View</a></td>
        </tr>
        @empty <tr><td colspan="7" class="px-4 py-8 text-center text-slate-400">No absences recorded.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
