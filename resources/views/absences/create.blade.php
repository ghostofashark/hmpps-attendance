@extends('layouts.app')
@section('title','Log Absence')
@section('content')
<div class="max-w-2xl">
  <h1 class="text-2xl font-bold text-slate-800 mb-6">Log New Absence</h1>
  <form method="POST" action="{{ route('absences.store') }}" class="bg-white rounded-2xl shadow-xl p-6 space-y-5" x-data="{illnessType: '', showWellbeing: false}">
    @csrf

    <div>
      <label class="block text-sm font-medium text-slate-700 mb-1">Staff Member</label>
      <select name="staff_id" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required>
        <option value="">-- Select staff member --</option>
        @foreach($staff as $member)
          <option value="{{ $member->id }}" {{ request('staff_id')==$member->id?'selected':'' }}>{{ $member->full_name }} ({{ $member->payroll_number }})</option>
        @endforeach
      </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Date Absence Started</label><input type="date" name="start_date" value="{{ old('start_date', now()->toDateString()) }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Date Returned (if known)</label><input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
    </div>

    <div x-data="{type: ''}">
      <label class="block text-sm font-medium text-slate-700 mb-1">Illness Type</label>
      <select name="illness_type" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required
        @change="type = $event.target.value">
        <option value="">-- Select illness type --</option>
        @foreach(['cold_flu'=>'Cold / Flu','back_pain'=>'Back Pain','stress'=>'Stress','anxiety'=>'Anxiety','depression'=>'Depression','ptsd'=>'PTSD','injury'=>'Injury','surgery'=>'Surgery / Medical','other'=>'Other'] as $val => $label)
          <option value="{{ $val }}" {{ old('illness_type')==$val?'selected':'' }}>{{ $label }}</option>
        @endforeach
      </select>
      <div x-show="['stress','anxiety','depression','ptsd'].includes(type)" x-cloak
        class="mt-3 bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
        <p class="font-bold mb-2">Wellbeing Support Available</p>
        <p>This absence type suggests the staff member may benefit from:</p>
        <ul class="list-disc ml-4 mt-2 space-y-1">
          <li>PAM Assist (Employee Assistance Programme)</li>
          <li>Mental Health Allies</li>
          <li>Occupational Health referral</li>
          <li>Workplace adjustments review</li>
        </ul>
        <p class="mt-2 text-xs">Please ensure these are discussed at first contact and in the return-to-work interview.</p>
      </div>
    </div>

    <div><label class="block text-sm font-medium text-slate-700 mb-1">Details / Notes</label><textarea name="illness_details" rows="3" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">{{ old('illness_details') }}</textarea></div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Manager Notes</label><textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">{{ old('notes') }}</textarea></div>

    @if($errors->any())<div class="bg-red-50 text-red-700 p-3 rounded-xl text-sm">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    <p class="text-xs text-slate-400">Action dates (14-day review, 28-day review, OH referral) will be calculated automatically.</p>
    <div class="flex gap-3">
      <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-700">Record Absence</button>
      <a href="{{ route('dashboard') }}" class="border border-slate-300 text-slate-700 px-6 py-2 rounded-xl">Cancel</a>
    </div>
  </form>
</div>
@endsection
