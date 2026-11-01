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
        Schema::create('urls', function (Blueprint $table) {
            $table->id();

            // User who created the URL
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Company to which the URL belongs
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();

            $table->text('original_url');

            // Unique short identifier
            $table->string('short_code', 20)->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
