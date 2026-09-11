@extends('layouts.app')
@section('title','Log Absence')
@section('content')
<div class='max-w-2xl'>
  <h1 class='text-2xl font-bold text-slate-800 mb-6'>Log New Absence</h1>
  <form method='POST' action='{{ route('absences.store') }}' class='bg-white rounded-2xl shadow-xl p-6 space-y-5' x-data='{illnessType: '', showWellbeing: false}'>
    @csrf

    <div>
      <label class='block text-sm font-medium text-slate-700 mb-1'>Staff Member</label>
      <select name='staff_id' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm' required>
        <option value=''>-- Select staff member --</option>
        @foreach($staff as $member)
          <option value='{{ $member->id }}' {{ request('staff_id')==$member->id?'selected':'' }}>{{ $member->full_name }} ({{ $member->payroll_number }})</option>
        @endforeach
      </select>
    </div>

    <div class='grid grid-cols-2 gap-4'>
      <div><label class='block text-sm font-medium text-slate-700 mb-1'>Date Absence Started</label><input type='date' name='start_date' value='{{ old('start_date', now()->toDateString()) }}' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm' required></div>
      <div><label class='block text-sm font-medium text-slate-700 mb-1'>Date Returned (if known)</label><input type='date' name='end_date' value='{{ old('end_date') }}' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm'></div>
    </div>

    <div x-data='{type: ''}'>
      <label class='block text-sm font-medium text-slate-700 mb-1'>Illness Type</label>
      <select name='illness_type' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm' required @change='type = $event.target.value'>
        <option value=''>-- Select illness type --</option>
        @foreach(['cold_flu'=>'Cold / Flu','back_pain'=>'Back Pain','stress'=>'Stress','anxiety'=>'Anxiety','depression'=>'Depression','ptsd'=>'PTSD','injury'=>'Injury','surgery'=>'Surgery / Medical','other'=>'Other'] as $val => $label)
          <option value='{{ $val }}' {{ old('illness_type')==$val?'selected':'' }}>{{ $label }}</option>
        @endforeach
      </select>
      <div x-show="['stress','anxiety','depression','ptsd'].includes(type)" x-cloak class='mt-3 bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800'>
        <p class='font-bold mb-2'>Wellbeing Support Available</p>
        <p>This absence type suggests the staff member may benefit from PAM Assist, Mental Health Allies, Occupational Health referral, or a Workplace adjustments review.</p>
      </div>
    </div>

    <div><label class='block text-sm font-medium text-slate-700 mb-1'>Details / Notes</label><textarea name='illness_details' rows='3' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm'>{{ old('illness_details') }}</textarea></div>
    <div><label class='block text-sm font-medium text-slate-700 mb-1'>Manager Notes</label><textarea name='notes' rows='2' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm'>{{ old('notes') }}</textarea></div>

    <!-- Part-Day Absence -->
    <div class='border border-gray-200 rounded-xl p-4 bg-gray-50' x-data='{partDay: false}'>
      <div class='flex items-center gap-2 mb-3'>
        <input type='checkbox' name='is_part_day' id='is_part_day' value='1' {{ old('is_part_day')?'checked':'' }} @change='partDay = $event.target.checked'>
        <label for='is_part_day' class='text-sm font-medium text-slate-700'>Part-Day Absence</label>
      </div>
      <div x-show='partDay' x-cloak>
        <label class='block text-sm font-medium text-slate-600 mb-1'>Part-Day Type</label>
        <select name='part_day_type' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm'>
          <option value=''>-- Select type --</option>
          <option value='half_day_am' {{ old('part_day_type')=='half_day_am'?'selected':'' }}>Half Day AM (counts as 0.5 days)</option>
          <option value='half_day_pm' {{ old('part_day_type')=='half_day_pm'?'selected':'' }}>Half Day PM (counts as 0.5 days)</option>
          <option value='less_than_half' {{ old('part_day_type')=='less_than_half'?'selected':'' }}>Less Than Half Day (counts as 0.5 days)</option>
          <option value='more_than_half' {{ old('part_day_type')=='more_than_half'?'selected':'' }}>More Than Half Day (not recorded for Bradford)</option>
        </select>
      </div>
    </div>

    <!-- Exclusion Reason -->
    <div>
      <label class='block text-sm font-medium text-slate-700 mb-1'>Exclusion Reason <span class='text-slate-400 font-normal'>(optional — excluded from Bradford &amp; trigger points)</span></label>
      <select name='exclusion_reason' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm'>
        <option value=''>None (normal absence)</option>
        <option value='pregnancy' {{ old('exclusion_reason')=='pregnancy'?'selected':'' }}>Pregnancy-related</option>
        <option value='assault_on_duty' {{ old('exclusion_reason')=='assault_on_duty'?'selected':'' }}>Assault on Duty</option>
        <option value='disability_adjustment_pending' {{ old('exclusion_reason')=='disability_adjustment_pending'?'selected':'' }}>Disability Adjustment Pending</option>
        <option value='gender_transition' {{ old('exclusion_reason')=='gender_transition'?'selected':'' }}>Gender Transition</option>
        <option value='injury_at_work' {{ old('exclusion_reason')=='injury_at_work'?'selected':'' }}>Injury at Work</option>
      </select>
    </div>

    <!-- Improvement Period Stage -->
    <div>
      <label class='block text-sm font-medium text-slate-700 mb-1'>Improvement Period Stage <span class='text-slate-400 font-normal'>(optional)</span></label>
      <select name='improvement_period_stage' class='w-full border border-gray-300 rounded-xl px-3 py-2 text-sm'>
        <option value=''>None</option>
        <option value='stage1_3month' {{ old('improvement_period_stage')=='stage1_3month'?'selected':'' }}>Stage 1 — 3 Month (25% trigger threshold)</option>
        <option value='stage2_6month' {{ old('improvement_period_stage')=='stage2_6month'?'selected':'' }}>Stage 2 — 6 Month (50% trigger threshold)</option>
        <option value='stage3_12month' {{ old('improvement_period_stage')=='stage3_12month'?'selected':'' }}>Stage 3 — 12 Month (normal trigger threshold)</option>
      </select>
    </div>

    @if($errors->any())<div class='bg-red-50 text-red-700 p-3 rounded-xl text-sm'>@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    <p class='text-xs text-slate-400'>Action dates (14-day informal review, 28-day formal review, monthly contacts, quarterly reviews) will be calculated automatically unless an exclusion reason is set.</p>
    <div class='flex gap-3'>
      <button type='submit' class='bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-700'>Record Absence</button>
      <a href='{{ route('dashboard') }}' class='border border-slate-300 text-slate-700 px-6 py-2 rounded-xl'>Cancel</a>
    </div>
  </form>
</div>
@endsection
