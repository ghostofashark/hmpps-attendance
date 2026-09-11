<?php
namespace App\Http\Controllers;
use App\Models\AbsenceRecord;
use App\Models\Staff;
use App\Services\ActionDateService;
use Illuminate\Http\Request;
class AbsenceController extends Controller {
    public function __construct(private ActionDateService $actionDates) {}
    public function index(Request $request) {
        $prisonId = auth()->user()->currentPrisonId();
        $absences = AbsenceRecord::with(['staff','prison','triggerPoints','contactLogs'])
            ->forPrison($prisonId)->latest('start_date')->paginate(25);
        return view('absences.index', compact('absences'));
    }
    public function create() {
        $prisonId = auth()->user()->currentPrisonId();
        $staff = Staff::where('prison_id', $prisonId)->where('is_active', true)->orderBy('last_name')->get();
        return view('absences.create', compact('staff'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'staff_id'               => 'required|exists:staff,id',
            'start_date'             => 'required|date',
            'end_date'               => 'nullable|date|after_or_equal:start_date',
            'illness_type'           => 'required|string',
            'illness_details'        => 'nullable|string',
            'notes'                  => 'nullable|string',
            'exclusion_reason'       => 'nullable|in:pregnancy,assault_on_duty,disability_adjustment_pending,gender_transition,injury_at_work',
            'is_part_day'            => 'boolean',
            'part_day_type'          => 'nullable|in:half_day_am,half_day_pm,less_than_half,more_than_half',
            'improvement_period_stage'=> 'nullable|in:stage1_3month,stage2_6month,stage3_12month',
        ]);
        $staff = Staff::findOrFail($validated['staff_id']);
        $absence = AbsenceRecord::create(array_merge($validated, [
            'prison_id'   => $staff->prison_id,
            'reported_by' => auth()->id(),
            'status'      => 'active',
            'risk_rating' => 'green',
            'is_part_day' => $request->boolean('is_part_day'),
        ]));
        $this->actionDates->calculateAndCreateTriggers($absence);
        return redirect()->route('absences.show', $absence)->with('success', 'Absence recorded.');
    }
    public function show(AbsenceRecord $absence) {
        $absence->load(['staff','prison','reportedBy','contactLogs.loggedBy','triggerPoints','documents','ohReferral','workplaceAdjustments','linkedAbsence']);
        $recentAbsences = AbsenceRecord::where('staff_id', $absence->staff_id)
            ->where('id', '!=', $absence->id)
            ->where('is_linked', false)
            ->where('start_date', '>=', now()->subMonths(3)->toDateString())
            ->latest('start_date')
            ->get();
        return view('absences.show', compact('absence', 'recentAbsences'));
    }
    public function edit(AbsenceRecord $absence) { return view('absences.edit', compact('absence')); }
    public function update(Request $request, AbsenceRecord $absence) {
        $absence->update($request->validate([
            'end_date'               => 'nullable|date',
            'status'                 => 'required|string',
            'risk_rating'            => 'required|in:green,amber,red',
            'notes'                  => 'nullable|string',
            'exclusion_reason'       => 'nullable|in:pregnancy,assault_on_duty,disability_adjustment_pending,gender_transition,injury_at_work',
            'is_part_day'            => 'boolean',
            'part_day_type'          => 'nullable|in:half_day_am,half_day_pm,less_than_half,more_than_half',
            'improvement_period_stage'=> 'nullable|in:stage1_3month,stage2_6month,stage3_12month',
        ]));
        return redirect()->route('absences.show', $absence)->with('success', 'Absence updated.');
    }
    public function toggleDailyList(AbsenceRecord $absence) {
        $absence->update(['include_in_daily_list' => !$absence->include_in_daily_list]);
        return back()->with('success', 'Daily list updated.');
    }
    public function rtwWizard(AbsenceRecord $absence) { return view('absences.rtw', compact('absence')); }
    public function linkAbsences(AbsenceRecord $absence, AbsenceRecord $previous) {
        if ($absence->illness_type !== $previous->illness_type) {
            return back()->with('error', 'Cannot link: absence illness types do not match.');
        }
        $previousEnd = $previous->end_date ?? now()->toDate();
        $gap = $previousEnd instanceof \Carbon\Carbon
            ? $previousEnd->diffInDays($absence->start_date)
            : \Carbon\Carbon::parse($previousEnd)->diffInDays($absence->start_date);
        if ($gap > 14) {
            return back()->with('error', 'Cannot link: gap between absences exceeds 14 days ('.$gap.' days).');
        }
        $absence->update(['linked_absence_id' => $previous->id, 'is_linked' => true]);
        return back()->with('success', 'Absences linked successfully. This absence is now linked to the previous episode.');
    }
}
