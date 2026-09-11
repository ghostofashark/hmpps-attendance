<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AuthorisedViewer extends Model {
    protected $fillable = ['email','name','reason','is_active','added_by','access_granted_at','access_expires_at'];
    protected $casts = [
        'is_active'          => 'boolean',
        'access_granted_at'  => 'datetime',
        'access_expires_at'  => 'datetime',
    ];
    public function addedBy() { return $this->belongsTo(User::class, 'added_by'); }

    public static function isAuthorised(string $email): bool {
        return static::where('email', $email)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('access_expires_at')
                     ->orWhere('access_expires_at', '>', now());
            })
            ->exists();
    }
}
