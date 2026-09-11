@extends('layouts.app')
@section('title','Absences')
@section('content')
<div class="space-y-4">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-slate-800">All Absences</h1>
    <a href="{{ route('absences.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm font-medium">+ Log Absence</a>
  </div>
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">Staff Member</th>
          <th class="px-4 py-3 text-left">Illness</th>
          <th class="px-4 py-3 text-left">Started</th>
          <th class="px-4 py-3 text-center">Days</th>
          <th class="px-4 py-3 text-center">Risk</th>
          <th class="px-4 py-3 text-left">Status</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($absences as $absence)
        <tr class="hover:bg-slate-50">
          <td class="px-4 py-3 font-medium">{{ $absence->staff->full_name }}</td>
          <td class="px-4 py-3 text-slate-600">{{ $absence->illness_type_label }}</td>
          <td class="px-4 py-3 text-slate-500">{{ $absence->start_date->format('d M Y') }}</td>
          <td class="px-4 py-3 text-center font-bold">{{ $absence->duration_days }}</td>
          <td class="px-4 py-3 text-center"><span class="px-2 py-0.5 rounded-full text-xs font-bold border {{ $absence->risk_color }}">{{ strtoupper($absence->risk_rating) }}</span></td>
          <td class="px-4 py-3 text-slate-500">{{ ucfirst(str_replace('_',' ',$absence->status)) }}</td>
          <td class="px-4 py-3"><a href="{{ route('absences.show', $absence) }}" class="text-xs bg-slate-800 text-white px-3 py-1 rounded-lg">View</a></td>
        </tr>
        @empty <tr><td colspan="7" class="px-4 py-12 text-center text-slate-400">No absences found.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $absences->links() }}</div>
  </div>
</div>
@endsection
