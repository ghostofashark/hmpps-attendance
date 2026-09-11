@extends('layouts.app')
@section('title','Authorised Viewers')
@section('content')
<div class="space-y-6">
  <div>
    <h1 class="text-2xl font-bold text-slate-800">Authorised Sick File Viewers</h1>
    <p class="text-slate-500 text-sm mt-1">
      Users on this list can view <strong>all</strong> absence records across all staff and prisons,
      regardless of whether they are the assigned line manager. Only HOBBA officers can manage this list.
    </p>
  </div>

  <!-- Add form -->
  <div class="bg-white rounded-2xl shadow-xl p-6">
    <h2 class="font-bold text-slate-700 mb-4">Add Authorised Viewer</h2>
    <form method="POST" action="{{ route('admin.authorised-viewers.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
      @csrf
      <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Dr Jane Smith" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required>
      </div>
      <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="j.smith@hmpps.gov.uk" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required>
      </div>
      <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Reason for Access</label>
        <input type="text" name="reason" value="{{ old('reason') }}" placeholder="e.g. Regional HR Manager" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" required>
      </div>
      <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Access Expires (optional)</label>
        <input type="date" name="access_expires_at" value="{{ old('access_expires_at') }}" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm">
      </div>
      @if($errors->any())
        <div class="md:col-span-4 bg-red-50 text-red-700 p-3 rounded-xl text-sm">
          @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
      @endif
      <div class="md:col-span-4">
        <button type="submit" class="bg-slate-800 text-white px-5 py-2 rounded-xl text-sm hover:bg-slate-700">Add to Authorised List</button>
      </div>
    </form>
  </div>

  <!-- Viewer list -->
  <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
    <div class="px-6 py-4 border-b bg-slate-50">
      <span class="text-sm font-medium text-slate-600">{{ $viewers->count() }} registered viewer(s)</span>
    </div>
    @if($viewers->isEmpty())
      <div class="px-6 py-12 text-center text-slate-400">
        <p class="text-lg mb-1">No authorised viewers</p>
        <p class="text-sm">Add email addresses above to grant full sick file access.</p>
      </div>
    @else
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
        <tr>
          <th class="px-4 py-3 text-left">Name</th>
          <th class="px-4 py-3 text-left">Email</th>
          <th class="px-4 py-3 text-left">Reason</th>
          <th class="px-4 py-3 text-left">Added By</th>
          <th class="px-4 py-3 text-left">Granted</th>
          <th class="px-4 py-3 text-left">Expires</th>
          <th class="px-4 py-3 text-center">Status</th>
          <th class="px-4 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @foreach($viewers as $viewer)
        <tr class="hover:bg-slate-50 {{ !$viewer->is_active ? 'opacity-50' : '' }}">
          <td class="px-4 py-3 font-medium">{{ $viewer->name }}</td>
          <td class="px-4 py-3 text-slate-600 font-mono text-xs">{{ $viewer->email }}</td>
          <td class="px-4 py-3 text-slate-500">{{ $viewer->reason }}</td>
          <td class="px-4 py-3 text-slate-400">{{ $viewer->addedBy->name }}</td>
          <td class="px-4 py-3 text-slate-400 text-xs">{{ $viewer->access_granted_at->format('d M Y') }}</td>
          <td class="px-4 py-3 text-xs">
            @if($viewer->access_expires_at)
              <span class="{{ $viewer->access_expires_at->isPast() ? 'text-red-600 font-bold' : 'text-slate-500' }}">
                {{ $viewer->access_expires_at->format('d M Y') }}
                {{ $viewer->access_expires_at->isPast() ? '(EXPIRED)' : '' }}
              </span>
            @else
              <span class="text-green-600">No expiry</span>
            @endif
          </td>
          <td class="px-4 py-3 text-center">
            <form method="POST" action="{{ route('admin.authorised-viewers.toggle', $viewer) }}">
              @csrf
              <button type="submit" class="px-2 py-0.5 rounded-full text-xs font-bold {{ $viewer->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $viewer->is_active ? 'Active' : 'Inactive' }}
              </button>
            </form>
          </td>
          <td class="px-4 py-3">
            <form method="POST" action="{{ route('admin.authorised-viewers.destroy', $viewer) }}" onsubmit="return confirm('Remove '. $viewer->name .' from authorised list?')">
              @csrf @method('DELETE')
              <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Remove</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>

  <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-sm text-amber-800">
    <p class="font-bold mb-1">Access Control Notice</p>
    <p>Users on this list can view all sick records regardless of prison or assignment. This access should only be granted to:</p>
    <ul class="list-disc ml-4 mt-2 space-y-1">
      <li>Occupational Health professionals</li>
      <li>Regional HR Managers</li>
      <li>Inspectors / Auditors with formal authorisation</li>
      <li>Governor / Deputy Governor (if not already assigned the Governor role)</li>
    </ul>
    <p class="mt-2">All access to this list is logged. Review regularly and remove expired entries.</p>
  </div>
</div>
@endsection
