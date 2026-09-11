<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('trigger_points', function (Blueprint $table) {
            $table->string('trigger_type')->change();
        });
    }
    public function down(): void {
        Schema::table('trigger_points', function (Blueprint $table) {
            $table->enum('trigger_type',['14_day_review','28_day_review','home_visit','oh_referral','improvement_period','bradford_trigger','formal_warning','rtw_interview'])->change();
        });
    }
};
