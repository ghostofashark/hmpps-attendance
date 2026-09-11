@extends('layouts.app')
@section('title','Add Staff Member')
@section('content')
<div class="max-w-2xl">
  <h1 class="text-2xl font-bold text-slate-800 mb-6">Add Staff Member</h1>
  <form method="POST" action="{{ route('staff.store') }}" class="bg-white rounded-2xl shadow-xl p-6 space-y-4">
    @csrf
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">First Name</label><input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Last Name</label><input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
    </div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Payroll Number</label><input type="text" name="payroll_number" value="{{ old('payroll_number') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Prison</label>
      <select name="prison_id" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required>
        @foreach($prisons as $prison)<option value="{{ $prison->id }}">{{ $prison->name }}</option>@endforeach
      </select></div>
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Job Title</label><input type="text" name="job_title" value="{{ old('job_title') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Department</label><input type="text" name="department" value="{{ old('department') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Band</label>
        <select name="band" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required>
          @foreach(['Band 2','Band 3','Band 4','Band 5','Band 7','Band 8','SEO','HEO'] as $band)<option value="{{ $band }}">{{ $band }}</option>@endforeach
        </select></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Line Manager</label>
        <select name="line_manager_id" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">
          <option value="">-- Select --</option>
          @foreach($managers as $manager)<option value="{{ $manager->id }}">{{ $manager->name }}</option>@endforeach
        </select></div>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Mobile</label><input type="text" name="mobile" value="{{ old('mobile') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
    </div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Home Address</label><textarea name="home_address" rows="3" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">{{ old('home_address') }}</textarea></div>
    <div class="grid grid-cols-2 gap-4">
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Next of Kin Name</label><input type="text" name="next_of_kin_name" value="{{ old('next_of_kin_name') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
      <div><label class="block text-sm font-medium text-slate-700 mb-1">Next of Kin Phone</label><input type="text" name="next_of_kin_phone" value="{{ old('next_of_kin_phone') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm"></div>
    </div>
    @if($errors->any())<div class="bg-red-50 text-red-700 p-3 rounded-xl text-sm">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
    <div class="flex gap-3">
      <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-xl hover:bg-slate-700">Save Staff Member</button>
      <a href="{{ route('staff.index') }}" class="border border-slate-300 text-slate-700 px-6 py-2 rounded-xl hover:bg-slate-50">Cancel</a>
    </div>
  </form>
</div>
@endsection
