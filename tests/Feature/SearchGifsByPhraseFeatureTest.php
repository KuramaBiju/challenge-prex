<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SearchGifsByPhraseFeatureTest extends TestCase
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

    public function test_search_gif_returns_data_with_valid_query_params(): void
    {
        $user = User::factory()->create(
            ['password' => Hash::make('password')]
        );

        $query = "funny cats";
        $limit = 10;
        $offset = 0;


        $userResponse = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $accessToken = $userResponse->json('access_token');


        $gifsFoundResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->getJson("/api/v1/gif/search?query=$query&limit=$limit&offset=$offset");

        $gifsFoundResponse->assertStatus(200);
    }

    public function test_search_gif_returns_error_with_invalid_data(): void
    {
        $user = User::factory()->create(
            ['password' => Hash::make('password')]
        );

        $limit = 10;
        $offset = 0;

        $userResponse = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $accessToken = $userResponse->json('access_token');


        $gifsNotFoundResponse = $this->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->getJson("/api/v1/gif/search?limit=$limit&offset=$offset");

        $gifsNotFoundResponse->assertStatus(422)
            ->assertJsonStructure([
                'message'
        ]);
    }

}
