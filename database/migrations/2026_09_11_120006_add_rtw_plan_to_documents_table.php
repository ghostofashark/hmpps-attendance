<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('document_type')->change();
        });
    }
    public function down(): void {
        Schema::table('documents', function (Blueprint $table) {
            $table->enum('document_type',['rtw_form','self_cert','farm_report','14_day_letter','28_day_letter','oh_referral_letter','improvement_warning','home_visit_record','handover_pack'])->change();
        });
    }
};
