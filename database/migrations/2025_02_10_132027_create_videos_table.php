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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->string('title');
            $table->string('slug');
            $table->string('url');
            $table->string('video_id');
            $table->string('video_duration');
            $table->decimal('view_cost', 10, 3);
            $table->integer('view_count');
            $table->decimal('amount', 10, 3);
            $table->decimal('amount_original', 10, 3);
            $table->boolean('status')->default(1);
            $table->boolean('hidden')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
