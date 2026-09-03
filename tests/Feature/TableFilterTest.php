<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableFilterTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first() ?? User::factory()->create();
    }

    public function test_productos_index_loads_with_search_and_pagination_limits(): void
    {
        $response = $this->actingAs($this->user)->get('/productos');
        $response->assertStatus(200);
        $response->assertSee('name="cantidad"', false);
        $response->assertSee('name="buscar"', false);
        $this->assertEquals(10, $response->viewData('items')->perPage());

        // Custom cantidad
        $responseCustom = $this->actingAs($this->user)->get('/productos?cantidad=5');
        $responseCustom->assertStatus(200);
        $this->assertEquals(5, $responseCustom->viewData('items')->perPage());

        // Max cantidad clamped to 20
        $responseMax = $this->actingAs($this->user)->get('/productos?cantidad=50');
        $responseMax->assertStatus(200);
        $this->assertEquals(20, $responseMax->viewData('items')->perPage());
    }

    public function test_proveedores_index_loads_with_search_and_pagination_limits(): void
    {
        $response = $this->actingAs($this->user)->get('/proveedores');
        $response->assertStatus(200);
        $response->assertSee('name="cantidad"', false);
        $response->assertSee('name="buscar"', false);
        $this->assertEquals(10, $response->viewData('items')->perPage());

        // Max cantidad clamped to 20
        $responseMax = $this->actingAs($this->user)->get('/proveedores?cantidad=100');
        $responseMax->assertStatus(200);
        $this->assertEquals(20, $responseMax->viewData('items')->perPage());
    }

    public function test_categorias_index_loads_with_search_and_pagination_limits(): void
    {
        $response = $this->actingAs($this->user)->get('/categorias');
        $response->assertStatus(200);
        $response->assertSee('name="cantidad"', false);
        $response->assertSee('name="buscar"', false);
        $this->assertEquals(10, $response->viewData('items')->perPage());

        $responseCustom = $this->actingAs($this->user)->get('/categorias?cantidad=15');
        $responseCustom->assertStatus(200);
        $this->assertEquals(15, $responseCustom->viewData('items')->perPage());

        // Test search
        Categoria::create(['nombre' => 'Bebidas', 'user_id' => $this->user->id]);
        Categoria::create(['nombre' => 'Golosinas', 'user_id' => $this->user->id]);

        $resSearch = $this->actingAs($this->user)->get('/categorias?buscar=Bebidas');
        $resSearch->assertStatus(200);
        $this->assertEquals(1, $resSearch->viewData('items')->total());
        $resSearch->assertSee('Bebidas');
        $resSearch->assertDontSee('Golosinas');
    }

    public function test_usuarios_index_and_tbody_load_with_search_and_pagination_limits(): void
    {
        $response = $this->actingAs($this->user)->get('/usuarios');
        $response->assertStatus(200);
        $response->assertSee('name="cantidad"', false);
        $response->assertSee('name="buscar"', false);
        $this->assertEquals(10, $response->viewData('items')->perPage());

        // Test tbody endpoint
        $responseTbody = $this->actingAs($this->user)->get('/usuarios/tbody?cantidad=5');
        $responseTbody->assertStatus(200);
        $this->assertEquals(5, $responseTbody->viewData('items')->perPage());

        // Test search filter
        $responseSearch = $this->actingAs($this->user)->get('/usuarios?buscar=' . $this->user->name);
        $responseSearch->assertStatus(200);
        $this->assertGreaterThanOrEqual(1, $responseSearch->viewData('items')->total());

        // Test search with no match shows empty message
        $responseNoMatch = $this->actingAs($this->user)->get('/usuarios?buscar=NonExistentUser12345');
        $responseNoMatch->assertStatus(200);
        $responseNoMatch->assertSee('No se encontraron usuarios');
    }
}
