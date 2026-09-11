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
            'staff_id'      => 'required|exists:staff,id',
            'start_date'    => 'required|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'illness_type'  => 'required|string',
            'illness_details'=> 'nullable|string',
            'notes'         => 'nullable|string',
        ]);
        $staff = Staff::findOrFail($validated['staff_id']);
        $absence = AbsenceRecord::create(array_merge($validated, [
            'prison_id'  => $staff->prison_id,
            'reported_by'=> auth()->id(),
            'status'     => 'active',
            'risk_rating'=> 'green',
        ]));
        $this->actionDates->calculateAndCreateTriggers($absence);
        return redirect()->route('absences.show', $absence)->with('success', 'Absence recorded.');
    }
    public function show(AbsenceRecord $absence) {
        $absence->load(['staff','prison','reportedBy','contactLogs.loggedBy','triggerPoints','documents','ohReferral','workplaceAdjustments']);
        return view('absences.show', compact('absence'));
    }
    public function edit(AbsenceRecord $absence) { return view('absences.edit', compact('absence')); }
    public function update(Request $request, AbsenceRecord $absence) {
        $absence->update($request->validate([
            'end_date'   => 'nullable|date',
            'status'     => 'required|string',
            'risk_rating'=> 'required|in:green,amber,red',
            'notes'      => 'nullable|string',
        ]));
        return redirect()->route('absences.show', $absence)->with('success', 'Absence updated.');
    }
    public function toggleDailyList(AbsenceRecord $absence) {
        $absence->update(['include_in_daily_list' => !$absence->include_in_daily_list]);
        return back()->with('success', 'Daily list updated.');
    }
    public function rtwWizard(AbsenceRecord $absence) { return view('absences.rtw', compact('absence')); }
}
