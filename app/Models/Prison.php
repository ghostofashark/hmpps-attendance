<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Prison extends Model {
    use HasFactory;
    protected $fillable = ['name','code','region','category','type','address','governor_name','is_active'];
    public function staff() { return $this->hasMany(Staff::class); }
    public function users() { return $this->hasMany(User::class); }
    public function absenceRecords() { return $this->hasMany(AbsenceRecord::class); }
    public function getCategoryLabelAttribute(): string {
        return match($this->category) {
            'A' => 'Category A', 'B' => 'Category B', 'C' => 'Category C',
            'D' => 'Category D (Open)', 'YOI' => 'Young Offender Institution',
            'IRC' => 'Immigration Removal Centre', 'HQ' => 'Headquarters',
            default => $this->category,
        };
    }
}
