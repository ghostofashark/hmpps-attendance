<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('prison_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('default_prison_id')->nullable()->constrained('prisons')->nullOnDelete();
            $table->string('job_title')->nullable();
            $table->string('payroll_number', 20)->nullable();
        });
    }
    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['prison_id','default_prison_id','job_title','payroll_number']);
        });
    }
};
