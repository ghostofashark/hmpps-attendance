<?php
namespace App\Http\Controllers;
use App\Models\AbsenceRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class DailySickListController extends Controller {
    public function index(Request $request) {
        $prisonId = auth()->user()->currentPrisonId();
        $date = $request->input('date', now()->toDateString());
        $absences = AbsenceRecord::with(['staff','triggerPoints','contactLogs'])
            ->active()->forPrison($prisonId)->get();
        return view('daily-sick-list.index', compact('absences','date'));
    }
    public function export() {
        $prisonId = auth()->user()->currentPrisonId();
        $absences = AbsenceRecord::with(['staff','prison'])
            ->active()->forPrison($prisonId)->where('include_in_daily_list', true)->get();
        return Pdf::loadView('daily-sick-list.pdf', compact('absences'))
            ->stream('sick-list-'.now()->format('Ymd').'.pdf');
    }
}
