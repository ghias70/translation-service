<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('content');
            $table->string('locale', 5);
            $table->string('tag')->nullable(); // e.g., mobile, desktop, web
            $table->timestamps();
    
            $table->unique(['key', 'locale']); // Ensure unique translations per locale
            $table->index(['key', 'locale']);
            $table->index('tag');

        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
