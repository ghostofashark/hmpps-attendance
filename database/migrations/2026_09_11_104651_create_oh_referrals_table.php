<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('oh_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absence_id')->constrained('absence_records')->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('referred_by')->constrained('users')->cascadeOnDelete();
            $table->date('referral_date');
            $table->text('questions_submitted')->nullable();
            $table->date('report_received_date')->nullable();
            $table->text('recommendations')->nullable();
            $table->enum('status',['pending','questions_submitted','awaiting_report','report_received','actions_complete'])->default('pending');
            $table->text('action_notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('oh_referrals'); }
};
