<?php
namespace App\Http\Controllers;
use App\Models\AbsenceRecord;
use App\Models\TriggerPoint;
use App\Services\ActionDateService;
use Illuminate\Http\Request;
class DashboardController extends Controller {
    public function index(Request $request) {
        $user = auth()->user();
        $prisonId = $user->currentPrisonId();
        $activeAbsences = AbsenceRecord::with(['staff','prison','triggerPoints','contactLogs'])
            ->active()->forPrison($prisonId)->orderBy('start_date')->get();
        $overdueTriggers = TriggerPoint::with(['absence.staff'])
            ->overdue()->whereHas('absence', fn($q) => $q->where('prison_id', $prisonId))->get();
        $upcomingTriggers = TriggerPoint::with(['absence.staff'])
            ->pending()
            ->whereBetween('action_due_date', [now()->toDateString(), now()->addDays(7)->toDateString()])
            ->whereHas('absence', fn($q) => $q->where('prison_id', $prisonId))
            ->orderBy('action_due_date')->get();
        $stats = [
            'active'   => $activeAbsences->count(),
            'overdue'  => $overdueTriggers->count(),
            'due_today'=> $upcomingTriggers->where('action_due_date', now()->toDateString())->count(),
            'red'      => $activeAbsences->where('risk_rating','red')->count(),
            'amber'    => $activeAbsences->where('risk_rating','amber')->count(),
            'green'    => $activeAbsences->where('risk_rating','green')->count(),
        ];
        return view('dashboard', compact('activeAbsences','overdueTriggers','upcomingTriggers','stats'));
    }
}
