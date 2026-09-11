<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('authorised_viewers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('reason')->nullable()->comment('Why this person requires full access');
            $table->boolean('is_active')->default(true);
            $table->foreignId('added_by')->constrained('users')->cascadeOnDelete();
            $table->timestamp('access_granted_at');
            $table->timestamp('access_expires_at')->nullable()->comment('Null = no expiry');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('authorised_viewers'); }
};
