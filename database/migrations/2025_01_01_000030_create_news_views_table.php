<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // One row per visitor IP per news item; used only to count unique views.
        Schema::create('news_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('news_id')->constrained('news')->cascadeOnDelete();
            $table->string('ip', 45);
            $table->timestamp('created_at')->nullable();

            $table->unique(['news_id', 'ip']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_views');
    }
};
