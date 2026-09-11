<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->enum('exclusion_reason',['pregnancy','assault_on_duty','disability_adjustment_pending','gender_transition','injury_at_work'])->nullable()->after('notes');
        });
    }
    public function down(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->dropColumn('exclusion_reason');
        });
    }
};
