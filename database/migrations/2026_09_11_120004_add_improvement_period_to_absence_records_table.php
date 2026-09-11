<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->enum('improvement_period_stage',['stage1_3month','stage2_6month','stage3_12month'])->nullable()->after('part_day_type');
        });
    }
    public function down(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->dropColumn('improvement_period_stage');
        });
    }
};
