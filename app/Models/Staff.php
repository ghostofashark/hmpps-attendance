<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Staff extends Model {
    use HasFactory;
    protected $fillable = [
        'prison_id','first_name','last_name','payroll_number','job_title','department',
        'band','email','phone','mobile','home_address','next_of_kin_name','next_of_kin_phone',
        'line_manager_id','hobba_id','date_of_birth','date_joined','is_active',
        'contracted_days_per_week',
    ];
    protected $casts = ['date_of_birth'=>'date','date_joined'=>'date','is_active'=>'boolean','contracted_days_per_week'=>'float'];
    public function prison() { return $this->belongsTo(Prison::class); }
    public function lineManager() { return $this->belongsTo(User::class, 'line_manager_id'); }
    public function hobba() { return $this->belongsTo(User::class, 'hobba_id'); }
    public function absenceRecords() { return $this->hasMany(AbsenceRecord::class); }
    public function activeAbsences() { return $this->hasMany(AbsenceRecord::class)->whereIn('status',['active','long_term','referred_oh']); }
    public function triggerPoints() { return $this->hasMany(TriggerPoint::class); }
    public function documents() { return $this->hasMany(Document::class); }
    public function workplaceAdjustments() { return $this->hasMany(WorkplaceAdjustment::class); }
    public function ohReferrals() { return $this->hasMany(OhReferral::class); }
    public function getFullNameAttribute(): string {
        return $this->first_name.' '.$this->last_name;
    }
    public function getBradfordScoreAttribute(): int {
        $absences = $this->absenceRecords()
            ->whereYear('start_date', now()->year)
            ->whereNull('exclusion_reason')
            ->get();
        $spells = $absences->count();
        $days   = $absences->sum(fn($a) => $a->duration_days);
        return (int)(($spells * $spells) * $days);
    }
}
