<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prison_id')->constrained()->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('payroll_number', 20)->unique();
            $table->string('job_title');
            $table->string('department');
            $table->string('band', 10);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->text('home_address')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->foreignId('line_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('hobba_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date_of_birth')->nullable();
            $table->date('date_joined')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('staff'); }
};
