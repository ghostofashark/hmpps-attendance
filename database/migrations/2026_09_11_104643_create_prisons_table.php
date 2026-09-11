<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('prisons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->string('region');
            $table->enum('category', ['A','B','C','D','YOI','IRC','HQ']);
            $table->enum('type', ['public','private'])->default('public');
            $table->string('address')->nullable();
            $table->string('governor_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('prisons'); }
};
