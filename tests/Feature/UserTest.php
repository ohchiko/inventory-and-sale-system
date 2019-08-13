<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
    }

    public function test_index()
    {
        $this->actingAs($this->user, 'api')
             ->json('get', route('users.index'))
             ->assertOk()
             ->assertJsonStructure([
                 'data' => [[ 'id', 'name', 'email', 'createdAt', 'updatedAt', 'deletedAt' ]]
             ]);
    }

    public function test_store()
    {
        $this->artisan('db:seed');

        $this->user->givePermissionTo('register user');

        $data = factory('App\User')->make();
        $data->password = 'password';
        $data->password_confirmation = $data->password;

        $this->actingAs($this->user, 'api')
             ->json('post', route('users.store'), $data->only([ 'name', 'email', 'password', 'password_confirmation' ]))
             ->assertStatus(201)
             ->assertJsonStructure([
                 'data' => [ 'id', 'name', 'email', 'createdAt', 'updatedAt', 'deletedAt' ]
             ])
             ->assertJson([
                 'data' => [
                     'name' => $data->name,
                     'email' => $data->email
                 ]
             ]);
    }

    public function test_show()
    {
        $this->actingAs($this->user, 'api')
             ->json('get', route('users.show', [ 'user' => $this->user->id ]))
             ->assertOk()
             ->assertJsonStructure([
                 'data' => [ 'id', 'name', 'email', 'createdAt', 'updatedAt', 'deletedAt' ]
             ])
             ->assertJson([ 'data' => [ 'id' => $this->user->id ] ]);
    }

    public function test_update()
    {
        $data = factory('App\User')->make();

        $this->actingAs($this->user, 'api')
             ->json('put', route('users.update', [ 'user' => $this->user->id ]), $data->only([ 'name', 'email' ]))
             ->assertOk()
             ->assertJsonStructure([
                 'data' => [ 'id', 'name', 'email', 'createdAt', 'updatedAt', 'deletedAt' ]
             ])
             ->assertJson([
                 'data' => [
                     'id' => $this->user->id,
                     'name' => $data->name,
                     'email' => $data->email
                 ]
             ]);
    }

    public function test_update_another_user()
    {
        $this->artisan('db:seed');

        $this->user->givePermissionTo('edit user');

        $data = factory('App\User')->create();
        $newData = $data;
        $newData->name = $this->faker->name;
        $newData->email = $this->faker->safeEmail;

        $this->actingAs($this->user, 'api')
             ->json('put', route('users.update', [ 'user' => $data->id ]), $newData->only([ 'name', 'email' ]))
             ->assertOk()
             ->assertJsonStructure([
                 'data' => [ 'id', 'name', 'email', 'createdAt', 'updatedAt', 'deletedAt' ]
             ])
             ->assertJson([
                 'data' => [
                     'id' => $data->id,
                     'name' => $newData->name,
                     'email' => $newData->email
                 ]
             ])
             ->assertJsonMissing([
                 'data' => [
                     'name' => $data->name,
                     'email' => $data->email
                 ]
             ]);
    }

    public function test_delete()
    {
        $this->actingAs($this->user, 'api')
             ->json('delete', route('users.destroy', [ 'user' => $this->user->id ]))
             ->assertOk()
             ->assertSee('Resource deleted successfully.');
    }

    public function test_delete_another_user()
    {
        $this->artisan('db:seed');

        $this->user->givePermissionTo('delete user');

        $data = factory('App\User')->create();

        $this->actingAs($this->user, 'api')
             ->json('delete', route('users.destroy', [ 'user' => $data->id ]))
             ->assertOk()
             ->assertSee('Resource deleted successfully.');
    }

    public function test_assign_role()
    {
        $this->artisan('db:seed');

        $this->user->givePermissionTo('assign role');

        $target = factory('App\User')->create();
        $data = Role::first()->name;

        $this->actingAs($this->user, 'api')
             ->json('patch', route('users.roles.assign', [ 'user' => $target->id ]), [ 'role' => $data ])
             ->assertOk()
             ->assertJson([
                 'data' => [
                     'id' => $target->id,
                     'roles' => [[ 'name' => $data ]]
                 ]
             ]);
    }

    public function test_remove_role()
    {
        $this->artisan('db:seed');

        $this->user->givePermissionTo('remove role');

        $target = factory('App\User')->create();
        $data = Role::first()->name;
        $target->assignRole($data);

        $this->actingAs($this->user, 'api')
             ->json('patch', route('users.roles.remove', [ 'user' => $target->id ]), [ 'role' => $data ])
             ->assertOk()
             ->assertJsonMissing([
                 'data' => [
                     'roles' => [[ 'name' => $data ]]
                 ]
             ]);
    }
}
