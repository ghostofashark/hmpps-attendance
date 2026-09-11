@extends('layouts.app')
@section('title','Edit Absence')
@section('content')
<div class="max-w-xl">
  <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Absence: {{ $absence->staff->full_name }}</h1>
  <form method="POST" action="{{ route('absences.update', $absence) }}" class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
    @csrf @method('PUT')
    <div><label class="block text-sm font-medium mb-1">End Date (leave blank if still absent)</label><input type="date" name="end_date" value="{{ $absence->end_date?->toDateString() }}" class="w-full border rounded-xl px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Status</label>
      <select name="status" class="w-full border rounded-xl px-3 py-2 text-sm" required>
        @foreach(['active','returned','long_term','referred_oh','formal_process'] as $status)
          <option value="{{ $status }}" {{ $absence->status==$status?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
        @endforeach
      </select></div>
    <div><label class="block text-sm font-medium mb-1">Risk Rating</label>
      <select name="risk_rating" class="w-full border rounded-xl px-3 py-2 text-sm" required>
        @foreach(['green','amber','red'] as $rating)
          <option value="{{ $rating }}" {{ $absence->risk_rating==$rating?'selected':'' }}>{{ ucfirst($rating) }}</option>
        @endforeach
      </select></div>
    <div><label class="block text-sm font-medium mb-1">Notes</label><textarea name="notes" rows="3" class="w-full border rounded-xl px-3 py-2 text-sm">{{ $absence->notes }}</textarea></div>

    <!-- Part-Day Absence -->
    <div class="border border-gray-200 rounded-xl p-4 bg-gray-50" x-data="{partDay: {{ $absence->is_part_day ? 'true' : 'false' }}}">
      <div class="flex items-center gap-2 mb-3">
        <input type="checkbox" name="is_part_day" id="is_part_day" value="1" {{ $absence->is_part_day?'checked':'' }} @change="partDay = $event.target.checked">
        <label for="is_part_day" class="text-sm font-medium text-slate-700">Part-Day Absence</label>
      </div>
      <div x-show="partDay" x-cloak>
        <label class="block text-sm font-medium text-slate-600 mb-1">Part-Day Type</label>
        <select name="part_day_type" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">
          <option value="">-- Select type --</option>
          <option value="half_day_am" {{ $absence->part_day_type=='half_day_am'?'selected':'' }}>Half Day AM</option>
          <option value="half_day_pm" {{ $absence->part_day_type=='half_day_pm'?'selected':'' }}>Half Day PM</option>
          <option value="less_than_half" {{ $absence->part_day_type=='less_than_half'?'selected':'' }}>Less Than Half Day</option>
          <option value="more_than_half" {{ $absence->part_day_type=='more_than_half'?'selected':'' }}>More Than Half Day (not recorded for Bradford)</option>
        </select>
      </div>
    </div>

    <!-- Exclusion Reason -->
    <div>
      <label class="block text-sm font-medium mb-1">Exclusion Reason <span class="text-slate-400 font-normal">(optional)</span></label>
      <select name="exclusion_reason" class="w-full border rounded-xl px-3 py-2 text-sm">
        <option value="">None (normal absence)</option>
        <option value="pregnancy" {{ $absence->exclusion_reason=='pregnancy'?'selected':'' }}>Pregnancy-related</option>
        <option value="assault_on_duty" {{ $absence->exclusion_reason=='assault_on_duty'?'selected':'' }}>Assault on Duty</option>
        <option value="disability_adjustment_pending" {{ $absence->exclusion_reason=='disability_adjustment_pending'?'selected':'' }}>Disability Adjustment Pending</option>
        <option value="gender_transition" {{ $absence->exclusion_reason=='gender_transition'?'selected':'' }}>Gender Transition</option>
        <option value="injury_at_work" {{ $absence->exclusion_reason=='injury_at_work'?'selected':'' }}>Injury at Work</option>
      </select>
    </div>

    <!-- Improvement Period Stage -->
    <div>
      <label class="block text-sm font-medium mb-1">Improvement Period Stage <span class="text-slate-400 font-normal">(optional)</span></label>
      <select name="improvement_period_stage" class="w-full border rounded-xl px-3 py-2 text-sm">
        <option value="">None</option>
        <option value="stage1_3month" {{ $absence->improvement_period_stage=='stage1_3month'?'selected':'' }}>Stage 1 — 3 Month (25% threshold)</option>
        <option value="stage2_6month" {{ $absence->improvement_period_stage=='stage2_6month'?'selected':'' }}>Stage 2 — 6 Month (50% threshold)</option>
        <option value="stage3_12month" {{ $absence->improvement_period_stage=='stage3_12month'?'selected':'' }}>Stage 3 — 12 Month (normal threshold)</option>
      </select>
    </div>

    <div class="flex gap-3">
      <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl">Save</button>
      <a href="{{ route('absences.show', $absence) }}" class="border border-slate-300 text-slate-700 px-6 py-2 rounded-xl">Cancel</a>
    </div>
  </form>
</div>
@endsection
