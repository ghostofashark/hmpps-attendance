<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->unsignedBigInteger('linked_absence_id')->nullable()->after('improvement_period_stage');
            $table->boolean('is_linked')->default(false)->after('linked_absence_id');
            $table->foreign('linked_absence_id')->references('id')->on('absence_records')->nullOnDelete();
        });
    }
    public function down(): void {
        Schema::table('absence_records', function (Blueprint $table) {
            $table->dropForeign(['linked_absence_id']);
            $table->dropColumn(['linked_absence_id','is_linked']);
        });
    }
};
