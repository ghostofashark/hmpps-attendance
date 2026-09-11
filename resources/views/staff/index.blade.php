@extends('layouts.app')
@section('title','Staff')
@section('content')
<div class="space-y-4">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-slate-800">Staff</h1>
    <a href="{{ route('staff.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-slate-700">+ Add Staff</a>
  </div>
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">Name</th>
          <th class="px-4 py-3 text-left">Payroll</th>
          <th class="px-4 py-3 text-left">Department</th>
          <th class="px-4 py-3 text-left">Band</th>
          <th class="px-4 py-3 text-center">Active Absences</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @forelse($staff as $member)
        <tr class="hover:bg-slate-50">
          <td class="px-4 py-3 font-medium">{{ $member->full_name }}</td>
          <td class="px-4 py-3 text-slate-500">{{ $member->payroll_number }}</td>
          <td class="px-4 py-3 text-slate-600">{{ $member->department }}</td>
          <td class="px-4 py-3 text-slate-600">{{ $member->band }}</td>
          <td class="px-4 py-3 text-center">
            @if($member->activeAbsences->count())
              <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-bold">{{ $member->activeAbsences->count() }}</span>
            @else <span class="text-slate-300">-</span> @endif
          </td>
          <td class="px-4 py-3"><a href="{{ route('staff.show', $member) }}" class="text-xs bg-slate-800 text-white px-3 py-1 rounded-lg">View</a></td>
        </tr>
        @empty <tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">No staff found.</td></tr>
        @endforelse
      </tbody>
    </table>
    <div class="px-4 py-3 border-t">{{ $staff->links() }}</div>
  </div>
</div>
@endsection
