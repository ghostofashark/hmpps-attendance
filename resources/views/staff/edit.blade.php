@extends('layouts.app')
@section('title','Edit '.$staff->full_name)
@section('content')
<div class="max-w-2xl">
  <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit: {{ $staff->full_name }}</h1>
  <form method="POST" action="{{ route('staff.update', $staff) }}" class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
    @csrf @method('PUT')
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">First Name</label><input type="text" name="first_name" value="{{ $staff->first_name }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Last Name</label><input type="text" name="last_name" value="{{ $staff->last_name }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
    </div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Job Title</label><input type="text" name="job_title" value="{{ $staff->job_title }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Department</label><input type="text" name="department" value="{{ $staff->department }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Band</label><input type="text" name="band" value="{{ $staff->band }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Phone</label><input type="text" name="phone" value="{{ $staff->phone }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Mobile</label><input type="text" name="mobile" value="{{ $staff->mobile }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
    </div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Email</label><input type="email" name="email" value="{{ $staff->email }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Home Address</label><textarea name="home_address" rows="3" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">{{ $staff->home_address }}</textarea></div>
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Line Manager</label>
        <select name="line_manager_id" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">
          <option value="">-- Select --</option>
          @foreach($managers as $manager)<option value="{{ $manager->id }}" {{ $staff->line_manager_id==$manager->id?'selected':'' }}>{{ $manager->name }}</option>@endforeach
        </select></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Next of Kin Name</label><input type="text" name="next_of_kin_name" value="{{ $staff->next_of_kin_name }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
    </div>
    <div class="flex gap-3">
      <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-700">Save Changes</button>
      <a href="{{ route('staff.show', $staff) }}" class="border border-slate-300 text-slate-700 px-6 py-2 rounded-xl">Cancel</a>
    </div>
  </form>
</div>
@endsection
