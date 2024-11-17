<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SaveGifFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        if (!file_exists(storage_path('oauth-private.key')) || !file_exists(storage_path('oauth-public.key'))) {
            Artisan::call('passport:install');
        }

        if (DB::table('oauth_clients')->where('personal_access_client', true)->doesntExist()) {
            Artisan::call('passport:client', [
                '--personal' => true,
                '--name' => 'Test Personal Access Client'
            ]);
        }
    }

    public function test_user_can_save_gif_successfully_with_valid_data(): void
    {
        $user = User::factory()->create(
            ['password' => Hash::make('password')]
        );

        $gif = [
            'alias' => 'Alias',
            'user_id' => $user->id,
            'gif_id' => 'xT9IgDEI1iZyb2wqo8',
        ];

        $userResponse = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $accessToken = $userResponse->json('access_token');

        $gifResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->postJson('/api/v1/gif/save', $gif);

        $gifResponse->assertStatus(201);
    }

    public function test_save_gif_with_invalid_data_returns_validation_error(): void
    {
        $user = User::factory()->create(
            ['password' => Hash::make('password')]
        );

        $gif = [
            'user_id' => $user->id,
            'gif_id' => 'xT9IgDEI1iZyb2wqo8',
        ];

        $userResponse = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $accessToken = $userResponse->json('access_token');

        $gifResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->postJson('/api/v1/gif/save', $gif);

        $gifResponse->assertStatus(422);
    }



}
