<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ContactLog extends Model {
    protected $fillable = ['absence_id','logged_by','contact_type','contact_direction','contacted_at','contact_outcome','pre_call_checklist','post_contact_notes','next_contact_due','kit_call'];
    protected $casts = ['contacted_at'=>'datetime','next_contact_due'=>'date','pre_call_checklist'=>'array','kit_call'=>'boolean'];
    public function absence() { return $this->belongsTo(AbsenceRecord::class, 'absence_id'); }
    public function loggedBy() { return $this->belongsTo(User::class, 'logged_by'); }
    public function getContactTypeLabelAttribute(): string {
        return match($this->contact_type) {
            'phone_call'=>'Phone Call','home_visit'=>'Home Visit','email'=>'Email',
            'letter'=>'Letter','teams_call'=>'Teams Call',default=>ucfirst($this->contact_type)
        };
    }
}
