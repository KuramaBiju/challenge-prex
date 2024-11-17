<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

trait SetsUpPassportTest
{
    use RefreshDatabase;
    protected function setUp(): void
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
}
