<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class AbsenceRecord extends Model {
    use HasFactory, SoftDeletes;
    protected $fillable = ['staff_id','prison_id','reported_by','start_date','end_date','illness_type','illness_details','status','include_in_daily_list','self_cert_required','self_cert_received','fit_note_required','fit_note_received','bradford_score','risk_rating','notes'];
    protected $casts = ['start_date'=>'date','end_date'=>'date','include_in_daily_list'=>'boolean','self_cert_required'=>'boolean','self_cert_received'=>'boolean','fit_note_required'=>'boolean','fit_note_received'=>'boolean'];
    public function staff() { return $this->belongsTo(Staff::class); }
    public function prison() { return $this->belongsTo(Prison::class); }
    public function reportedBy() { return $this->belongsTo(User::class, 'reported_by'); }
    public function contactLogs() { return $this->hasMany(ContactLog::class, 'absence_id'); }
    public function triggerPoints() { return $this->hasMany(TriggerPoint::class, 'absence_id'); }
    public function documents() { return $this->hasMany(Document::class, 'absence_id'); }
    public function ohReferral() { return $this->hasOne(OhReferral::class, 'absence_id'); }
    public function workplaceAdjustments() { return $this->hasMany(WorkplaceAdjustment::class, 'absence_id'); }
    public function getDurationDaysAttribute(): int {
        $end = $this->end_date ?? Carbon::today();
        return max(1, $this->start_date->diffInDays($end) + 1);
    }
    public function getComputedRiskRatingAttribute(): string {
        $days = $this->duration_days;
        if ($this->status === 'formal_process') return 'red';
        if ($days >= 28 || $this->status === 'long_term' || $this->status === 'referred_oh') return 'red';
        if ($days >= 14) return 'amber';
        if ($days >= 7) return 'amber';
        return 'green';
    }
    public function getIllnessTypeLabelAttribute(): string {
        return match($this->illness_type) {
            'cold_flu' => 'Cold/Flu', 'back_pain' => 'Back Pain', 'stress' => 'Stress',
            'anxiety' => 'Anxiety', 'depression' => 'Depression', 'ptsd' => 'PTSD',
            'injury' => 'Injury', 'surgery' => 'Surgery/Medical', 'other' => 'Other',
            default => ucfirst($this->illness_type),
        };
    }
    public function requiresWellbeingSupport(): bool {
        return in_array($this->illness_type, ['stress','anxiety','depression','ptsd']);
    }
    public function getRiskColorAttribute(): string {
        return match($this->risk_rating) {
            'red' => 'bg-red-100 text-red-800 border-red-200',
            'amber' => 'bg-amber-100 text-amber-800 border-amber-200',
            default => 'bg-green-100 text-green-800 border-green-200',
        };
    }
    public function scopeActive($query) { return $query->whereIn('status',['active','long_term','referred_oh','formal_process']); }
    public function scopeForPrison($query, $prisonId) { return $query->where('prison_id', $prisonId); }
}
