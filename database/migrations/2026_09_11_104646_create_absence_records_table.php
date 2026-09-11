<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('absence_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->foreignId('prison_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('users')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('illness_type',['cold_flu','back_pain','stress','anxiety','depression','ptsd','injury','surgery','other']);
            $table->text('illness_details')->nullable();
            $table->enum('status',['active','returned','long_term','referred_oh','formal_process'])->default('active');
            $table->boolean('include_in_daily_list')->default(true);
            $table->boolean('self_cert_required')->default(false);
            $table->boolean('self_cert_received')->default(false);
            $table->boolean('fit_note_required')->default(false);
            $table->boolean('fit_note_received')->default(false);
            $table->integer('bradford_score')->default(0);
            $table->enum('risk_rating',['green','amber','red'])->default('green');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void { Schema::dropIfExists('absence_records'); }
};
