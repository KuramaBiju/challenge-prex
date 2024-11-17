<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SearchGifByIdFeatureTest extends TestCase
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

    public function test_search_gif_returns_data_with_valid_id(): void
    {
        $user = User::factory()->create(
            ['password' => Hash::make('password')]
        );
        $validGifId = 'jIlbY3PMd9PNuHnXNe';

        $userResponse = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $accessToken = $userResponse->json('access_token');

        $gifFoundResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->getJson("/api/v1/gif/search/$validGifId");

        $gifFoundResponse->assertStatus(200);
    }

    public function test_search_gif_returns_error_with_invalid_id(): void
    {
        $user = User::factory()->create(
            ['password' => Hash::make('password')]
        );
        $invalidGifId = 'invalid_gif_id';

        $userResponse = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $accessToken = $userResponse->json('access_token');

        $gifNotFoundResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->getJson("/api/v1/gif/search/$invalidGifId");

        $gifNotFoundResponse->assertStatus(400)
            ->assertJsonStructure([
                'message'
            ]);
    }

}
