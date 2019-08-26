<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SKUTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Run database seeders
        $this->artisan('db:seed');

        $this->user = factory('App\User')->create()
                                         ->assignRole('produksi');
    }

    public function test_index()
    {
        factory('App\SKU', 3)->create([ 'user_id' => $this->user->id ]);

        $this->actingAs($this->user, 'api')
             ->json('get', route('sku.index'))
             ->assertOk()
             ->assertJsonStructure([
                 'data' => [[ 'id', 'description', 'price' ]]
             ]);
    }

    public function test_store()
    {
        $sku = factory('App\SKU')->make();

        $components = factory('App\Component', 3)->create([ 'user_id' => $this->user->givePermissionTo('create component')->id ]);

        $this->actingAs($this->user, 'api')
             ->json('post', route('sku.store'), (function () use($sku, $components) { $sku->components = $components->pluck('id'); return $sku->toArray(); })())
             ->assertStatus(201)
             ->assertJson([
                 'data' => [
                     'name' => $sku->name,
                     'price' => $sku->price,
                     'components' => $components->makeHidden([ 'user_id', 'updated_at', 'created_at' ])->toArray(),
                 ]
             ]);

        $this->assertDatabaseHas('skus', $sku->makeHidden('components')->toArray());
    }

    public function test_show()
    {
        $sku = factory('App\SKU')->create([ 'user_id' => $this->user->id ]);

        $this->actingAs($this->user, 'api')
             ->json('get', route('sku.show', [ 'sku' => $sku->id ]))
             ->assertOk()
             ->assertJson([
                 'data' => [
                     'id' => $sku->id,
                     'price' => $sku->price,
                     'components' => []
                 ]
             ]);
    }

    public function test_update()
    {
        $sku = factory('App\SKU')->create([ 'user_id' => $this->user->id ]);

        $updates = factory('App\SKU')->make();

        $this->actingAs($this->user, 'api')
             ->json('put', route('sku.update', [ 'sku' => $sku->id ]), $updates->toArray())
             ->assertOk()
             ->assertJson([
                 'data' => [
                     'id' => $sku->id,
                     'name' => $updates->name,
                     'price' => $updates->price
                 ]
             ]);

        $this->assertDatabaseHas('skus', $updates->toArray());
        $this->assertDatabaseMissing('skus', $sku->toArray());
    }

    public function test_destroy()
    {
        $sku = factory('App\SKU')->create([ 'user_id' => $this->user->id ]);

        $this->actingAs($this->user, 'api')
             ->json('delete', route('sku.destroy', [ 'sku' => $sku->id ]))
             ->assertOk();

        $this->assertSoftDeleted('skus', $sku->toArray());
    }
}
