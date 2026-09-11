<?php
namespace App\Services;
use App\Models\AbsenceRecord;
use App\Models\TriggerPoint;
use Carbon\Carbon;
class ActionDateService {
    public function calculateAndCreateTriggers(AbsenceRecord $absence): void {
        if ($absence->isExcluded()) {
            return;
        }
        $start = Carbon::parse($absence->start_date);
        $triggers = [
            ['informal_review_14d',       $start->copy()->addDays(14)],
            ['formal_review_28d',         $start->copy()->addDays(28)],
            ['informal_contact_42d',      $start->copy()->addDays(42)],
            ['informal_contact_56d',      $start->copy()->addDays(56)],
            ['informal_contact_70d',      $start->copy()->addDays(70)],
            ['informal_contact_84d',      $start->copy()->addDays(84)],
            ['formal_review_quarterly1',  $start->copy()->addDays(91)],
            ['formal_review_quarterly2',  $start->copy()->addDays(182)],
        ];
        foreach ($triggers as [$type, $dueDate]) {
            TriggerPoint::firstOrCreate(
                ['absence_id' => $absence->id, 'trigger_type' => $type],
                [
                    'staff_id'        => $absence->staff_id,
                    'triggered_at'    => now()->toDateString(),
                    'action_due_date' => $dueDate->toDateString(),
                    'is_overdue'      => $dueDate->isPast(),
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
            ->whereYear('start_date', now()->year)
            ->whereNull('exclusion_reason')
            ->get();
        $spells = $absences->count();
        $days   = $absences->sum(fn($a) => $a->duration_days);
        return (int)(($spells * $spells) * $days);
    }
    public function getNextActionDue(AbsenceRecord $absence): ?TriggerPoint {
        return $absence->triggerPoints()
            ->whereNull('completed_at')
            ->orderBy('action_due_date')
            ->first();
    }
}
