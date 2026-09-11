<?php
namespace App\Http\Controllers;
use App\Models\AbsenceRecord;
use App\Models\TriggerPoint;
use App\Models\Prison;
use App\Models\User;
use Illuminate\Http\Request;
class GovernorDashboardController extends Controller {
    public function index() {
        $prisonId = auth()->user()->currentPrisonId();
        $prison = Prison::findOrFail($prisonId);
        $absences = AbsenceRecord::with(['staff','contactLogs','triggerPoints'])->active()->forPrison($prisonId)->get();
        $overdueTriggers = TriggerPoint::overdue()->whereHas('absence', fn($q) => $q->where('prison_id', $prisonId))->count();
        $noContact = $absences->filter(fn($a) => $a->contactLogs->isEmpty())->count();
        $managers = User::with(['managedStaff.activeAbsences'])->where('prison_id', $prisonId)->get();
        return view('governor.dashboard', compact('prison','absences','overdueTriggers','noContact','managers'));
    }
}
