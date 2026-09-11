<?php
namespace App\Http\Controllers;
use App\Models\AbsenceRecord;
use App\Models\Prison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StatisticsController extends Controller {
    public function index(Request $request) {
        $scope = $request->input('scope','local');
        $prisonId = auth()->user()->currentPrisonId();
        $byIllness = AbsenceRecord::select('illness_type', DB::raw('count(*) as total'))
            ->when($scope==='local', fn($q) => $q->where('prison_id', $prisonId))
            ->groupBy('illness_type')->get();
        $byPrison = Prison::withCount(['absenceRecords as active_count' => fn($q) => $q->active()])->get();
        $monthly = AbsenceRecord::select(DB::raw("strftime('%Y-%m', start_date) as month"), DB::raw('count(*) as total'))
            ->when($scope==='local', fn($q) => $q->where('prison_id', $prisonId))
            ->groupBy('month')->orderBy('month')->limit(12)->get();
        return view('statistics.index', compact('byIllness','byPrison','monthly','scope'));
    }
}
