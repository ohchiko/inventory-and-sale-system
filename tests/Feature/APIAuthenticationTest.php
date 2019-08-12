<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APIAuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        //$this->artisan('db:seed');
        $this->user = factory('App\User')->create();
    }

    public function test_login()
    {
        $this->actingAs($this->user, 'api')
             ->json('get', route('users.index'))
             ->assertOk();
    }

    public function test_login_via_headers()
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->user->api_token
        ])
             ->json('get', route('users.index'))
             ->assertOk();
    }

    public function test_unauthorized()
    {
        $this->json('get', route('users.index'))
             ->assertUnauthorized();
    }
}
