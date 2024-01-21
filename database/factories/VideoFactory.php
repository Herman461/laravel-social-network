<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $files = Storage::disk('public')->allFiles("videos");
        $randomFile = $files[rand(0, count($files) - 1)];
        return [
            'user_id' => 1,
            'views' => 0,
            'name' => basename($randomFile)
        ];
    }
}
