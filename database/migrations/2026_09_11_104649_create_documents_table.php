<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absence_id')->nullable()->constrained('absence_records')->nullOnDelete();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('generated_by')->constrained('users')->cascadeOnDelete();
            $table->enum('document_type',['rtw_form','self_cert','farm_report','14_day_letter','28_day_letter','oh_referral_letter','improvement_warning','home_visit_record','handover_pack']);
            $table->string('file_path')->nullable();
            $table->dateTime('generated_at');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('documents'); }
};
