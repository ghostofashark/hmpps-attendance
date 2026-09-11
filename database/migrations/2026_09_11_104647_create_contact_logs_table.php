<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('contact_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absence_id')->constrained('absence_records')->cascadeOnDelete();
            $table->foreignId('logged_by')->constrained('users')->cascadeOnDelete();
            $table->enum('contact_type',['phone_call','home_visit','email','letter','teams_call']);
            $table->enum('contact_direction',['outbound','inbound']);
            $table->dateTime('contacted_at');
            $table->enum('contact_outcome',['spoke_to_staff','left_voicemail','no_answer','staff_unavailable','letter_sent']);
            $table->json('pre_call_checklist')->nullable();
            $table->text('post_contact_notes')->nullable();
            $table->date('next_contact_due')->nullable();
            $table->boolean('kit_call')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('contact_logs'); }
};
