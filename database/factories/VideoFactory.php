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
            'user_id' => random_int(1, 10),
            'views' => random_int(0, 100000),
            'name' => basename($randomFile),
            'preview' => '/storage/images/videos/1706201816.jpg', //TODO: убрать статическую строку
            'created_at' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s')
        ];
    }
}
