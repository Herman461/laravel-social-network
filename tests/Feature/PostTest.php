<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\PostRequest;
use App\Models\Post;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $rules;
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    static public function invalidFormData(): array {
        return [
            "A request cannot be passed because the field 'text' is empty" => [
                [
                    'text' => null,
                ],
                ['text']
            ],
            "A request cannot be passed because the field 'text' contains more than 5096 symbols" => [
                [
                    'text' => fake()->text(6000),
                ],
                ['text']
            ]
        ];
    }

    /**
     * Test each of the validation rules
     *
     * @dataProvider invalidFormData
     */
    public function test_all_validation($invalidData, $invalidFields): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('post.store'), $invalidData);

        $response->assertSessionHasErrors($invalidFields);

    }

    /**
     * @test
     */
    public function test_a_post_have_been_successfully_added_to_database(): void
    {
        $this->withoutExceptionHandling();

        $data = [
            'text' => fake()->sentence(10, true),
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('post.store'), $data);
        $response->assertOk();

        $this->assertDatabaseCount('posts', 1);
    }

    /**
     * @test
     */
    public function test_a_post_can_be_added_only_by_auth_user(): void
    {
        $data = [
            'text' => fake()->sentence(10, true),

        ];

        $response = $this->postJson(route('post.store'), $data);
        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function test_increment_views_when_user_checked_a_post(): void
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $views = $post->views;
        $data = ['id' => $post->id, 'views' => $views + 1];

        $response = $this->actingAs($this->user)
            ->patchJson(route('patch.views.increment', [$post->id]));

        $response->assertOk();
        $response->assertJson($data);

        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * @test
     */
    public function test_not_increment_views_if_user_is_unauthorized(): void
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->patchJson(route('patch.views.increment', [$post->id]));

    }


    /**
     * @test
     */
    public function test_a_image_can_be_save_to_database(): void
    {
        $this->withoutExceptionHandling();

        $post = Post::factory()->create();

        Storage::fake('photos');

        $response = $this->actingAs($this->user)->postJson('/post/store', [
            UploadedFile::fake()->image('photo1.jpg')
        ]);
//        $images = fake()->image(null, 640, 480);

        Storage::disk('photos')->assertExists('photo1.jpg');
    }
}
