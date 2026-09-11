<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable {
    use HasFactory, Notifiable, HasRoles;
    protected $fillable = ['name','email','password','prison_id','default_prison_id','job_title','payroll_number'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array {
        return ['email_verified_at'=>'datetime','password'=>'hashed'];
    }
    public function prison() { return $this->belongsTo(Prison::class); }
    public function defaultPrison() { return $this->belongsTo(Prison::class, 'default_prison_id'); }
    public function managedStaff() { return $this->hasMany(Staff::class, 'line_manager_id'); }
    public function currentPrisonId(): int|null { return $this->default_prison_id ?? $this->prison_id; }
}
