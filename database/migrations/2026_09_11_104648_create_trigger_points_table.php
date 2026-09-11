<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('trigger_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absence_id')->constrained('absence_records')->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->enum('trigger_type',['14_day_review','28_day_review','home_visit','oh_referral','improvement_period','bradford_trigger','formal_warning','rtw_interview']);
            $table->date('triggered_at');
            $table->date('action_due_date');
            $table->dateTime('completed_at')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('outcome')->nullable();
            $table->boolean('is_overdue')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('trigger_points'); }
};
