<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class OhReferral extends Model {
    protected $fillable = ['absence_id','staff_id','referred_by','referral_date','questions_submitted','report_received_date','recommendations','status','action_notes'];
    protected $casts = ['referral_date'=>'date','report_received_date'=>'date'];
    public function absence() { return $this->belongsTo(AbsenceRecord::class, 'absence_id'); }
    public function staff() { return $this->belongsTo(Staff::class); }
    public function referredBy() { return $this->belongsTo(User::class, 'referred_by'); }
}
