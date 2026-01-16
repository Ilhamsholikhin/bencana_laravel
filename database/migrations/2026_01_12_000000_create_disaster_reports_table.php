<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disaster_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('type', 50);
            $table->string('location', 120);
            $table->dateTime('occurred_at');
            $table->unsignedTinyInteger('severity')->default(3); // 1-5
            $table->string('status', 30)->default('Terpantau');
            $table->text('description')->nullable();
            $table->unsignedInteger('casualties')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('source_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_reports');
    }
};
