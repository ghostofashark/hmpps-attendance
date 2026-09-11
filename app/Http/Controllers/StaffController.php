<?php
namespace App\Http\Controllers;
use App\Models\Staff;
use App\Models\Prison;
use App\Models\User;
use Illuminate\Http\Request;
class StaffController extends Controller {
    public function index(Request $request) {
        $prisonId = auth()->user()->currentPrisonId();
        $staff = Staff::with(['prison','lineManager','activeAbsences'])
            ->where('prison_id', $prisonId)->orderBy('last_name')->paginate(30);
        return view('staff.index', compact('staff'));
    }
    public function create() {
        $prisons = Prison::where('is_active', true)->orderBy('name')->get();
        $managers = User::orderBy('name')->get();
        return view('staff.create', compact('prisons','managers'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'prison_id'      => 'required|exists:prisons,id',
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'payroll_number' => 'required|string|max:20|unique:staff',
            'job_title'      => 'required|string|max:100',
            'department'     => 'required|string|max:100',
            'band'           => 'required|string|max:10',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string|max:20',
            'mobile'         => 'nullable|string|max:20',
            'home_address'   => 'nullable|string',
            'line_manager_id'=> 'nullable|exists:users,id',
        ]);
        $staff = Staff::create($validated);
        return redirect()->route('staff.show', $staff)->with('success', 'Staff member added.');
    }
    public function show(Staff $staff) {
        $staff->load(['prison','lineManager','absenceRecords.triggerPoints','workplaceAdjustments','ohReferrals']);
        return view('staff.show', compact('staff'));
    }
    public function edit(Staff $staff) {
        $prisons = Prison::where('is_active', true)->orderBy('name')->get();
        $managers = User::orderBy('name')->get();
        return view('staff.edit', compact('staff','prisons','managers'));
    }
    public function update(Request $request, Staff $staff) {
        $staff->update($request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'job_title'      => 'required|string|max:100',
            'department'     => 'required|string|max:100',
            'band'           => 'required|string|max:10',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string|max:20',
            'mobile'         => 'nullable|string|max:20',
            'home_address'   => 'nullable|string',
            'line_manager_id'=> 'nullable|exists:users,id',
        ]));
        return redirect()->route('staff.show', $staff)->with('success', 'Staff member updated.');
    }
}
