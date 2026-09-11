<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class WorkplaceAdjustment extends Model {
    protected $fillable = ['staff_id','absence_id','recorded_by','adjustment_type','description','start_date','review_date','end_date','status','passport_notes'];
    protected $casts = ['start_date'=>'date','review_date'=>'date','end_date'=>'date'];
    public function staff() { return $this->belongsTo(Staff::class); }
    public function absence() { return $this->belongsTo(AbsenceRecord::class, 'absence_id'); }
    public function recordedBy() { return $this->belongsTo(User::class, 'recorded_by'); }
}
