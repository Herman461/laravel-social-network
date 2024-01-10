<?php

use App\Models\User;
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
        Schema::create('author_follower', function (Blueprint $table) {

            $table->unsignedBigInteger('author_id');
            $table->index('author_id');
            $table->foreign('author_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('follower_id');
            $table->index('follower_id');
            $table->foreign('follower_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(["author_id", "follower_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (app()->isLocal()) {
            Schema::dropIfExists('author_follower');
        }
    }
};
