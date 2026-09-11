<?php
namespace App\Services;
use App\Models\AbsenceRecord;
use App\Models\TriggerPoint;
use Carbon\Carbon;
class ActionDateService {
    public function calculateAndCreateTriggers(AbsenceRecord $absence): void {
        $start = Carbon::parse($absence->start_date);
        $triggers = [
            ['14_day_review', $start->copy()->addDays(14)],
            ['28_day_review', $start->copy()->addDays(28)],
            ['home_visit',    $start->copy()->addDays(28)],
            ['oh_referral',   $start->copy()->addDays(28)],
        ];
        foreach ($triggers as [$type, $dueDate]) {
            TriggerPoint::firstOrCreate(
                ['absence_id' => $absence->id, 'trigger_type' => $type],
                [
                    'staff_id'       => $absence->staff_id,
                    'triggered_at'   => now()->toDateString(),
                    'action_due_date'=> $dueDate->toDateString(),
                    'is_overdue'     => $dueDate->isPast(),
                ]
            );
        }
    }
    public function updateOverdueStatus(): void {
        TriggerPoint::whereNull('completed_at')
            ->where('action_due_date', '<', now()->toDateString())
            ->update(['is_overdue' => true]);
    }
    public function calculateBradfordScore(int $staffId): int {
        $absences = AbsenceRecord::where('staff_id', $staffId)
            ->whereYear('start_date', now()->year)->get();
        $spells = $absences->count();
        $days = $absences->sum(fn($a) => $a->duration_days);
        return ($spells * $spells) * $days;
    }
    public function getNextActionDue(AbsenceRecord $absence): ?TriggerPoint {
        return $absence->triggerPoints()
            ->whereNull('completed_at')
            ->orderBy('action_due_date')
            ->first();
    }
}
