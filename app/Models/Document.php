<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Document extends Model {
    protected $fillable = ['absence_id','staff_id','generated_by','document_type','file_path','generated_at','metadata'];
    protected $casts = ['generated_at'=>'datetime','metadata'=>'array'];
    public function absence() { return $this->belongsTo(AbsenceRecord::class, 'absence_id'); }
    public function staff() { return $this->belongsTo(Staff::class); }
    public function generatedBy() { return $this->belongsTo(User::class, 'generated_by'); }
    public function getTypeLabelAttribute(): string {
        return match($this->document_type) {
            'rtw_form'=>'Return to Work Form','self_cert'=>'Self-Certification','farm_report'=>'FARM Report',
            '14_day_letter'=>'14-Day Review Letter','28_day_letter'=>'28-Day Review Letter',
            'oh_referral_letter'=>'OH Referral Letter','improvement_warning'=>'Improvement Warning',
            'home_visit_record'=>'Home Visit Record','handover_pack'=>'Handover Pack',
            default=>ucfirst($this->document_type)
        };
    }
}
