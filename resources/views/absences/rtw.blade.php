@extends('layouts.app')
@section('title','Return to Work Wizard')
@section('content')
<div class="max-w-2xl" x-data="{
  step: 1,
  fit: null,
  discussion: '',
  support: [],
  adjustments: false,
  adjustmentDetail: '',
  notes: ''
}">
  <h1 class="text-2xl font-bold text-slate-800 mb-2">Return to Work Wizard</h1>
  <p class="text-slate-500 text-sm mb-6">{{ DVArabsence->staff->full_name }} &mdash; Absent since {{ DVArabsence->start_date->format('d M Y') }} ({{ DVArabsence->duration_days }} days)</p>

  <div class="bg-white rounded-2xl shadow-xl p-6">

    <!-- Step 1 -->
    <div x-show="step === 1">
      <p class="font-bold text-lg text-slate-800 mb-6">Step 1 of 6: Is the employee fit to return to work today?</p>
      <div class="flex gap-4">
        <button @click="fit = true; step = 2" class="flex-1 border-2 rounded-2xl p-6 text-center hover:border-green-400 hover:bg-green-50" :class="fit===true ? 'border-green-400 bg-green-50' : 'border-gray-200'"><span class="text-2xl">✓</span><p class="font-bold mt-2">Yes, fit to return</p></button>
        <button @click="fit = false; step = 2" class="flex-1 border-2 rounded-2xl p-6 text-center hover:border-red-400 hover:bg-red-50" :class="fit===false ? 'border-red-400 bg-red-50' : 'border-gray-200'"><span class="text-2xl">✗</span><p class="font-bold mt-2">Not yet fit</p></button>
      </div>
    </div>

    <!-- Step 2 -->
    <div x-show="step === 2">
      <p class="font-bold text-lg text-slate-800 mb-4">Step 2 of 6: Did you discuss the nature of their absence?</p>
      <textarea x-model="discussion" rows="5" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" placeholder="Note what was discussed, any explanation given by the staff member, relevant circumstances..."></textarea>
      <div class="flex gap-3 mt-4"><button @click="step=1" class="border border-gray-300 px-4 py-2 rounded-xl text-sm">Back</button><button @click="step=3" class="bg-slate-800 text-white px-6 py-2 rounded-xl text-sm">Next</button></div>
    </div>

    <!-- Step 3 -->
    <div x-show="step === 3">
      <p class="font-bold text-lg text-slate-800 mb-4">Step 3 of 6: Is any support needed?</p>
      <div class="space-y-2">
        @foreach(['PAM Assist (EAP)','Occupational Health Referral','Mental Health Ally','Workplace Adjustment','Phased Return to Work','Reduced Hours'] as $option)
        <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-slate-50">
          <input type="checkbox" :value="'{{ $option }}' " x-model="support" class="rounded">
          <span class="text-sm">{{ $option }}</span>
        </label>
        @endforeach
      </div>
      <div class="flex gap-3 mt-4"><button @click="step=2" class="border border-gray-300 px-4 py-2 rounded-xl text-sm">Back</button><button @click="step=4" class="bg-slate-800 text-white px-6 py-2 rounded-xl text-sm">Next</button></div>
    </div>

    <!-- Step 4 -->
    <div x-show="step === 4">
      <p class="font-bold text-lg text-slate-800 mb-4">Step 4 of 6: Are any workplace adjustments needed?</p>
      <div class="flex gap-4 mb-4">
        <button @click="adjustments = true" class="flex-1 border-2 rounded-xl p-4 text-center" :class="adjustments===true ? 'border-blue-400 bg-blue-50' : 'border-gray-200'">Yes</button>
        <button @click="adjustments = false" class="flex-1 border-2 rounded-xl p-4 text-center" :class="adjustments===false ? 'border-green-400 bg-green-50' : 'border-gray-200'">No</button>
      </div>
      <div x-show="adjustments"><textarea x-model="adjustmentDetail" rows="3" class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm" placeholder="Describe the adjustments needed..."></textarea></div>
      <div class="flex gap-3 mt-4"><button @click="step=3" class="border border-gray-300 px-4 py-2 rounded-xl text-sm">Back</button><button @click="step=5" class="bg-slate-800 text-white px-6 py-2 rounded-xl text-sm">Next</button></div>
    </div>

    <!-- Step 5 -->
    <div x-show="step === 5">
      <p class="font-bold text-lg text-slate-800 mb-2">Step 5 of 6: Formal Action Check</p>
      <div class="bg-slate-50 border rounded-xl p-4 text-sm mb-4">
        <p class="font-medium mb-2">Bradford Factor Score: <strong>{{ DVArabsence->staff->bradford_score }}</strong></p>
        @if(DVArabsence->staff->bradford_score > 200) <p class="text-red-600">⚠ Score exceeds 200 — formal attendance action may be required.</p>
        @elseif(DVArabsence->staff->bradford_score > 100) <p class="text-amber-600">⚠ Score exceeds 100 — management review recommended.</p>
        @else <p class="text-green-600">✓ Score within acceptable range.</p> @endif
      </div>
      <div><label class="block text-sm font-medium mb-1">Additional Manager Notes</label><textarea x-model="notes" rows="3" class="w-full border rounded-xl px-3 py-2 text-sm"></textarea></div>
      <div class="flex gap-3 mt-4"><button @click="step=4" class="border border-gray-300 px-4 py-2 rounded-xl text-sm">Back</button><button @click="step=6" class="bg-slate-800 text-white px-6 py-2 rounded-xl text-sm">Next</button></div>
    </div>

    <!-- Step 6: Confirm & Generate -->
    <div x-show="step === 6">
      <p class="font-bold text-lg text-slate-800 mb-4">Step 6 of 6: Confirm &amp; Generate RTW Document</p>
      <div class="bg-slate-50 rounded-xl p-4 text-sm space-y-2 mb-4">
        <p><strong>Fit to return:</strong> <span x-text="fit ? 'Yes' : 'Not yet'"></span></p>
        <p><strong>Discussion:</strong> <span x-text="discussion || 'Not recorded'"></span></p>
        <p><strong>Support needed:</strong> <span x-text="support.join(', ') || 'None identified'"></span></p>
        <p><strong>Adjustments:</strong> <span x-text="adjustments ? adjustmentDetail : 'None'"></span></p>
      </div>
      <form method="POST" action="{{ route('documents.generate', [DVArabsence, 'rtw_form']) }}">
        @csrf
        <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-green-700 mb-3">Generate RTW Document &amp; Complete</button>
      </form>
      <a href="{{ route('absences.show', DVArabsence) }}" class="block text-center text-slate-500 text-sm">Complete without generating document</a>
    </div>

    <!-- Progress indicator -->
    <div class="flex gap-1 justify-center mt-6">
      @for($i = 1; $i <= 6; $i++)
        <div class="w-2 h-2 rounded-full transition-all" :class="step >= {{ $i }} ? 'bg-slate-800' : 'bg-slate-200'"></div>
      @endfor
    </div>
  </div>
</div>
@endsection
