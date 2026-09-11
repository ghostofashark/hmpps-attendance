<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TriggerPoint extends Model {
    protected $fillable = ['absence_id','staff_id','trigger_type','triggered_at','action_due_date','completed_at','completed_by','outcome','is_overdue'];
    protected $casts = ['triggered_at'=>'date','action_due_date'=>'date','completed_at'=>'datetime','is_overdue'=>'boolean'];
    public function absence() { return $this->belongsTo(AbsenceRecord::class, 'absence_id'); }
    public function staff() { return $this->belongsTo(Staff::class); }
    public function completedBy() { return $this->belongsTo(User::class, 'completed_by'); }
    public function getLabelAttribute(): string {
        return match($this->trigger_type) {
            '14_day_review'           => '14-Day Review',
            '28_day_review'           => '28-Day Review',
            'informal_review_14d'     => '14-Day Informal Review',
            'formal_review_28d'       => '28-Day Formal Review',
            'informal_contact_42d'    => 'Monthly Informal Contact (Week 6)',
            'informal_contact_56d'    => 'Monthly Informal Contact (Week 8)',
            'informal_contact_70d'    => 'Monthly Informal Contact (Week 10)',
            'informal_contact_84d'    => 'Monthly Informal Contact (Week 12)',
            'formal_review_quarterly1'=> 'Quarterly Formal Review (3 Months)',
            'formal_review_quarterly2'=> 'Quarterly Formal Review (6 Months)',
            'home_visit'              => 'Home Visit',
            'oh_referral'             => 'OH Referral',
            'improvement_period'      => 'Improvement Period',
            'bradford_trigger'        => 'Bradford Trigger',
            'formal_warning'          => 'Formal Warning',
            'rtw_interview'           => 'Return to Work Interview',
            default => ucfirst(str_replace('_',' ',$this->trigger_type)),
        };
    }
    public function scopeOverdue($query) { return $query->where('is_overdue', true)->whereNull('completed_at'); }
    public function scopePending($query) { return $query->whereNull('completed_at'); }
}
