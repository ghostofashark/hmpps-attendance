<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->boolean('is_part_day')->default(false)->after('exclusion_reason');
            $table->enum('part_day_type',['half_day_am','half_day_pm','less_than_half','more_than_half'])->nullable()->after('is_part_day');
        });
    }
    public function down(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->dropColumn(['is_part_day','part_day_type']);
        });
    }
};
