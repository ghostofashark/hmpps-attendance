<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('workplace_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('absence_id')->nullable()->constrained('absence_records')->nullOnDelete();
            $table->foreignId('recorded_by')->constrained('users')->cascadeOnDelete();
            $table->string('adjustment_type');
            $table->text('description');
            $table->date('start_date');
            $table->date('review_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status',['active','under_review','completed'])->default('active');
            $table->text('passport_notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('workplace_adjustments'); }
};
