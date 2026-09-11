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
            '14_day_review'=>'14-Day Review','28_day_review'=>'28-Day Review','home_visit'=>'Home Visit',
            'oh_referral'=>'OH Referral','improvement_period'=>'Improvement Period',
            'bradford_trigger'=>'Bradford Trigger','formal_warning'=>'Formal Warning',
            'rtw_interview'=>'Return to Work Interview',default=>ucfirst($this->trigger_type)
        };
    }
    public function scopeOverdue($query) { return $query->where('is_overdue', true)->whereNull('completed_at'); }
    public function scopePending($query) { return $query->whereNull('completed_at'); }
}
