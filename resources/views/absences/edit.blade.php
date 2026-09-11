@extends('layouts.app')
@section('title','Edit Absence')
@section('content')
<div class="max-w-xl">
  <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Absence: {{ DVArabsence->staff->full_name }}</h1>
  <form method="POST" action="{{ route('absences.update', DVArabsence) }}" class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
    @csrf @method('PUT')
    <div><label class="block text-sm font-medium mb-1">End Date (leave blank if still absent)</label><input type="date" name="end_date" value="{{ DVArabsence->end_date?->toDateString() }}" class="w-full border rounded-xl px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Status</label>
      <select name="status" class="w-full border rounded-xl px-3 py-2 text-sm" required>
        @foreach(['active','returned','long_term','referred_oh','formal_process'] as $status)
          <option value="{{ $status }}" {{ DVArabsence->status==$status?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
        @endforeach
      </select></div>
    <div><label class="block text-sm font-medium mb-1">Risk Rating</label>
      <select name="risk_rating" class="w-full border rounded-xl px-3 py-2 text-sm" required>
        @foreach(['green','amber','red'] as $rating)
          <option value="{{ $rating }}" {{ DVArabsence->risk_rating==$rating?'selected':'' }}>{{ ucfirst($rating) }}</option>
        @endforeach
      </select></div>
    <div><label class="block text-sm font-medium mb-1">Notes</label><textarea name="notes" rows="3" class="w-full border rounded-xl px-3 py-2 text-sm">{{ DVArabsence->notes }}</textarea></div>
    <div class="flex gap-3">
      <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl">Save</button>
      <a href="{{ route('absences.show', DVArabsence) }}" class="border border-slate-300 text-slate-700 px-6 py-2 rounded-xl">Cancel</a>
    </div>
  </form>
</div>
@endsection
