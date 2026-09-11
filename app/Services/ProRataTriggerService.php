<?php
namespace App\Services;
class ProRataTriggerService {
    public function calculateTriggerDays(float $contractedDaysPerWeek): int {
        return max(2, (int) ceil($contractedDaysPerWeek * 1.6));
    }
    public function getThresholds(float $contractedDaysPerWeek): array {
        $trigger = $this->calculateTriggerDays($contractedDaysPerWeek);
        return [
            'trigger_days'       => $trigger,
            'improvement_25pct'  => max(2, (int) ceil($trigger * 0.25)),
            'improvement_50pct'  => max(2, (int) ceil($trigger * 0.50)),
        ];
    }
}
