<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create()
        );
    }

    public function test_index()
    {

        $product = Product::factory()->count(5)->create();

        $response = $this->json('GET', '/api/products');

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json')
            ->assertJsonCount(5,'data');
/*
        factory(Product::class, 5)->create();

        $response = $this->getJson('/api/products');

        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(5);*/

    }

    public function test_create_new_product()
    {
        /*
        $data = [
            'name' => 'Hola',
            'price' => 1000,
        ];
        $response = $this->postJson('/api/products', $data);

        $response->assertSuccessful();
        //$response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
        */
        $data = [
            'name' => 'Hola',
            'price' => 1000,
        ];
        $response = $this->json('POST', '/api/products', $data);

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');

        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_product()
    {

        /** @var Product $product */
        /*
        $product = $this->factory(Product::class)->create();

        $data = [
            'name' => 'Update Product',
            'price' => 20000,
        ];

        $response = $this->patchJson("/api/products/{$product->getKey()}", $data);
        $response->assertSuccessful();
        //$response->assertHeader('content-type', 'application/json');
        */
        $product = Product::factory()->create();

        $data = [
            'name' => 'Update Product',
            'price' => 20000,
        ];

        $response = $this->json('PATCH', "/api/products/{$product->getKey()}", $data);

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');
    }

    public function test_show_product()
    {
        /** @var Product $product */
        /*
        $product = factory(Product::class)->create();

        $response = $this->getJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        //$response->assertHeader('content-type', 'application/json');
        */
        $product = Product::factory()->create();;

        $response = $this->json('GET', "/api/products/{$product->getKey()}");

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');
    }

    public function test_delete_product()
    {
        /** @var Product $product */
        /*
        $product = factory(Product::class)->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response->assertSuccessful();
        //$response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
        */
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');

        $this->assertDeleted($product);
    }

    private function factory(string $class)
    {
    }

}
