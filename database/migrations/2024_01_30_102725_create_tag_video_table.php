<?php

use App\Models\Tag;
use App\Models\Video;
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
        Schema::create('tag_video', function (Blueprint $table) {

            $table->unsignedBigInteger('tag_id');
            $table->index('tag_id');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('video_id');
            $table->index('video_id');
            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(["tag_id", "video_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('tag_video');
        }
    }
};
