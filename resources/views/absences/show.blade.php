@extends('layouts.app')
@section('title', $absence->staff->full_name.' - Absence')
@section('content')
<div class="space-y-6">

  @if(session('success'))<div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm">{{ session('success') }}</div>@endif
  @if(session('error'))<div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 text-sm">{{ session('error') }}</div>@endif

  <!-- Header -->
  <div class="flex justify-between items-start">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">{{ $absence->staff->full_name }}</h1>
      <p class="text-slate-500 text-sm">{{ $absence->illness_type_label }} &middot; Started {{ $absence->start_date->format('d M Y') }} &middot; {{ $absence->duration_days }} days</p>
    </div>
    <div class="flex gap-2 flex-wrap">
      <span class="px-3 py-1 rounded-full text-sm font-bold border {{ $absence->risk_color }}">{{ strtoupper($absence->risk_rating) }} RISK</span>
      @if($absence->isExcluded())
        <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 border border-purple-200">EXCLUDED: {{ $absence->exclusion_reason_label }}</span>
      @endif
      @if(!$absence->end_date)
        <a href="{{ route('absences.rtw', $absence) }}" class="bg-green-600 text-white px-4 py-1.5 rounded-xl text-sm hover:bg-green-700">RTW Wizard</a>
      @endif
      <a href="{{ route('absences.edit', $absence) }}" class="border border-slate-300 text-slate-700 px-4 py-1.5 rounded-xl text-sm">Edit</a>
    </div>
  </div>

  @if($absence->requiresWellbeingSupport())
  <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-sm text-amber-800">
    <strong>Wellbeing Note:</strong> This absence type ({{ $absence->illness_type_label }}) may require additional support referrals. Consider PAM Assist, Mental Health Allies, or OH referral.
  </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left: Details + Actions -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Absence Details Card -->
      <div class="bg-white rounded-2xl shadow-xl p-6">
        <h2 class="font-bold text-slate-700 mb-4">Absence Details</h2>
        <dl class="grid grid-cols-2 gap-3 text-sm">
          <div><dt class="text-slate-400">Status</dt><dd class="font-medium">{{ ucfirst(str_replace('_',' ',$absence->status)) }}</dd></div>
          <div><dt class="text-slate-400">Bradford Score (YTD)</dt><dd class="font-medium">{{ $absence->staff->bradford_score }}</dd></div>
          <div><dt class="text-slate-400">Effective Trigger Days</dt><dd class="font-medium">{{ $absence->effective_trigger_days }}</dd></div>
          <div><dt class="text-slate-400">Improvement Stage</dt><dd class="font-medium">{{ $absence->improvement_period_stage ? ucfirst(str_replace('_',' ',$absence->improvement_period_stage)) : 'None' }}</dd></div>
          <div><dt class="text-slate-400">Self-cert Required</dt><dd>{{ $absence->self_cert_required ? ($absence->self_cert_received ? 'Received' : 'Outstanding') : 'N/A' }}</dd></div>
          <div><dt class="text-slate-400">Fit Note Required</dt><dd>{{ $absence->fit_note_required ? ($absence->fit_note_received ? 'Received' : 'Outstanding') : 'N/A' }}</dd></div>
          <div><dt class="text-slate-400">Reported by</dt><dd>{{ $absence->reportedBy->name }}</dd></div>
          <div><dt class="text-slate-400">Prison</dt><dd>{{ $absence->prison->name }}</dd></div>
          @if($absence->is_part_day)
          <div><dt class="text-slate-400">Part-Day Type</dt><dd class="font-medium">{{ ucfirst(str_replace('_',' ',$absence->part_day_type)) }}</dd></div>
          @endif
          @if($absence->isExcluded())
          <div class="col-span-2"><dt class="text-slate-400">Exclusion Reason</dt><dd class="font-medium text-purple-700">{{ $absence->exclusion_reason_label }} — excluded from Bradford &amp; trigger points</dd></div>
          @endif
          @if($absence->is_linked && $absence->linkedAbsence)
          <div class="col-span-2"><dt class="text-slate-400">Linked to Previous Absence</dt><dd class="font-medium">{{ $absence->linkedAbsence->illness_type_label }} — started {{ $absence->linkedAbsence->start_date->format('d M Y') }}</dd></div>
          @endif
        </dl>
        @if($absence->notes)<p class="mt-4 text-sm text-slate-600 bg-slate-50 rounded-xl p-3">{{ $absence->notes }}</p>@endif
      </div>

      <!-- Action Dates -->
      <div class="bg-white rounded-2xl shadow-xl p-6">
        <h2 class="font-bold text-slate-700 mb-4">Action Dates</h2>
        @if($absence->isExcluded())
          <p class="text-sm text-purple-700 bg-purple-50 rounded-xl p-3">No trigger points created — this absence is excluded from the formal process ({{ $absence->exclusion_reason_label }}).</p>
        @else
        <div class="space-y-2">
          @forelse($absence->triggerPoints->sortBy('action_due_date') as $trigger)
          <div class="flex items-center justify-between px-4 py-3 rounded-xl border {{ $trigger->completed_at ? 'bg-green-50 border-green-200' : ($trigger->is_overdue ? 'bg-red-50 border-red-200' : 'bg-white border-gray-200') }}">
            <div>
              <span class="font-medium text-sm">{{ $trigger->label }}</span>
              <div class="text-xs text-slate-400">Due: {{ $trigger->action_due_date->format('d M Y') }}</div>
            </div>
            @if($trigger->completed_at)
              <span class="text-xs text-green-700 font-medium">Completed {{ $trigger->completed_at->format('d M') }}</span>
            @elseif($trigger->is_overdue)
              <span class="text-xs text-red-700 font-bold">OVERDUE</span>
            @else
              <span class="text-xs text-slate-500">{{ $trigger->action_due_date->diffForHumans() }}</span>
            @endif
          </div>
          @empty <p class="text-slate-400 text-sm">No trigger points calculated.</p>
          @endforelse
        </div>
        @endif
      </div>

      <!-- Contact Logs -->
      <div class="bg-white rounded-2xl shadow-xl p-6">
        <div class="flex justify-between mb-4">
          <h2 class="font-bold text-slate-700">Contact Log ({{ $absence->contactLogs->count() }})</h2>
        </div>
        <div class="space-y-3 mb-4">
          @forelse($absence->contactLogs->sortByDesc('contacted_at') as $log)
          <div class="border border-gray-200 rounded-xl p-4">
            <div class="flex justify-between text-sm mb-1">
              <span class="font-medium">{{ $log->contact_type_label }} &mdash; {{ ucfirst($log->contact_outcome) }}</span>
              <span class="text-slate-400">{{ $log->contacted_at->format('d M Y H:i') }}</span>
            </div>
            <p class="text-sm text-slate-600">{{ $log->post_contact_notes }}</p>
            @if($log->kit_call)<span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">KIT Call</span>@endif
            @if($log->next_contact_due)<p class="text-xs text-slate-400 mt-1">Next contact due: {{ $log->next_contact_due->format('d M Y') }}</p>@endif
          </div>
          @empty <p class="text-slate-400 text-sm">No contact logged yet.</p>
          @endforelse
        </div>

        <!-- Add Contact Form -->
        <div class="border-t pt-4">
          <h3 class="font-medium text-slate-700 text-sm mb-3">Log Contact</h3>
          <form method="POST" action="{{ route('contact-logs.store', $absence) }}" class="grid grid-cols-2 gap-3">
            @csrf
            <div><label class="block text-xs font-medium text-slate-600 mb-1">Contact Type</label>
              <select name="contact_type" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm" required>
                <option value="phone_call">Phone Call</option>
                <option value="home_visit">Home Visit</option>
                <option value="teams_call">Teams Call</option>
                <option value="email">Email</option>
                <option value="letter">Letter</option>
              </select></div>
            <div><label class="block text-xs font-medium text-slate-600 mb-1">Direction</label>
              <select name="contact_direction" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm" required>
                <option value="outbound">Outbound (I contacted them)</option>
                <option value="inbound">Inbound (They contacted me)</option>
              </select></div>
            <div><label class="block text-xs font-medium text-slate-600 mb-1">Date &amp; Time</label>
              <input type="datetime-local" name="contacted_at" value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm" required></div>
            <div><label class="block text-xs font-medium text-slate-600 mb-1">Outcome</label>
              <select name="contact_outcome" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm" required>
                <option value="spoke_to_staff">Spoke to staff member</option>
                <option value="left_voicemail">Left voicemail</option>
                <option value="no_answer">No answer</option>
                <option value="staff_unavailable">Staff unavailable</option>
                <option value="letter_sent">Letter sent</option>
              </select></div>
            <div class="col-span-2"><label class="block text-xs font-medium text-slate-600 mb-1">Notes</label>
              <textarea name="post_contact_notes" rows="3" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm" placeholder="Welfare discussed, fit note status, expected return date, support offered..."></textarea></div>
            <div><label class="block text-xs font-medium text-slate-600 mb-1">Next Contact Due</label>
              <input type="date" name="next_contact_due" class="w-full border border-gray-300 rounded-lg px-2 py-1.5 text-sm"></div>
            <div class="flex items-end">
              <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="kit_call" value="1"> KIT (Keep in Touch) Call</label>
            </div>
            <div class="col-span-2">
              <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-slate-700">Save Contact Log</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Link to Previous Absence -->
      @if(!$absence->is_linked && $recentAbsences->count())
      <div class="bg-white rounded-2xl shadow-xl p-6">
        <h2 class="font-bold text-slate-700 mb-2">Link to Previous Absence</h2>
        <p class="text-sm text-slate-500 mb-4">Link this absence to a previous episode of the same illness type (within 14 days). Linked absences are treated as a single episode for policy purposes.</p>
        <div class="space-y-2">
          @foreach($recentAbsences as $prev)
          <div class="flex items-center justify-between border border-gray-200 rounded-xl px-4 py-3">
            <div class="text-sm">
              <span class="font-medium">{{ $prev->illness_type_label }}</span>
              <span class="text-slate-400 ml-2">{{ $prev->start_date->format('d M Y') }}@if($prev->end_date) — {{ $prev->end_date->format('d M Y') }}@endif</span>
              @if($prev->illness_type !== $absence->illness_type)
                <span class="ml-2 text-xs text-amber-600">(different illness type)</span>
              @endif
            </div>
            <form method="POST" action="{{ route('absences.link', [$absence, $prev]) }}">
              @csrf
              <button class="bg-slate-700 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-slate-600">Link</button>
            </form>
          </div>
          @endforeach
        </div>
      </div>
      @endif

    </div>

    <!-- Right: Documents + OH -->
    <div class="space-y-6">

      <!-- Documents -->
      <div class="bg-white rounded-2xl shadow-xl p-6">
        <h2 class="font-bold text-slate-700 mb-4">Documents</h2>
        <div class="space-y-2">
          @foreach(['rtw_form'=>'Return to Work Form','rtw_plan'=>'Return to Work Plan','self_cert'=>'Self-Certification','14_day_letter'=>'14-Day Review Letter','28_day_letter'=>'28-Day Review Letter','farm_report'=>'FARM Report','oh_referral_letter'=>'OH Referral Letter'] as $type => $label)
          <form method="POST" action="{{ route('documents.generate', [$absence, $type]) }}">
            @csrf
            <button class="w-full text-left border border-gray-200 rounded-xl px-3 py-2 text-sm hover:bg-slate-50 hover:border-slate-300 transition-all">
              <span class="font-medium">{{ $label }}</span>
            </button>
          </form>
          @endforeach
        </div>
        @if($absence->documents->count())
        <div class="mt-4 border-t pt-4">
          <p class="text-xs font-medium text-slate-500 mb-2">Previously Generated</p>
          @foreach($absence->documents->sortByDesc('generated_at') as $doc)
          <div class="text-xs text-slate-600 py-1">{{ $doc->type_label }} &mdash; {{ $doc->generated_at->format('d M Y H:i') }}</div>
          @endforeach
        </div>
        @endif
      </div>

      <!-- Include in Sick List -->
      <div class="bg-white rounded-2xl shadow-xl p-4">
        <h2 class="font-bold text-slate-700 mb-3 text-sm">Daily Sick List</h2>
        <form method="POST" action="{{ route('absences.toggle-daily-list', $absence) }}">
          @csrf
          <button class="w-full border rounded-xl px-3 py-2 text-sm {{ $absence->include_in_daily_list ? 'bg-green-50 border-green-300 text-green-700' : 'bg-gray-50 border-gray-300 text-gray-500' }}">
            {{ $absence->include_in_daily_list ? 'Included in daily list — click to exclude' : 'Excluded from daily list — click to include' }}
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection
