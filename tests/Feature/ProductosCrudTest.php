<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductosCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $categoria;
    protected $proveedor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->categoria = Categoria::create([
            'nombre' => 'Tecnología',
            'user_id' => $this->user->id,
        ]);
        $this->proveedor = Proveedor::create([
            'nombre' => 'Proveedor Global',
            'telefono' => '1234567890',
            'email' => 'proveedor@test.com',
            'cp' => '1000',
        ]);
    }

    public function test_can_view_create_product_page(): void
    {
        $response = $this->actingAs($this->user)->get('/productos/create');
        $response->assertStatus(200);
        $response->assertSee('Crear Producto');
        $response->assertSee('Tecnología');
        $response->assertSee('Proveedor Global');
    }

    public function test_can_store_product(): void
    {
        $data = [
            'nombre' => 'Laptop Gamer',
            'category_id' => $this->categoria->id,
            'proveedor_id' => $this->proveedor->id,
            'precio_compra' => 800.50,
            'precio_venta' => 1200.00,
            'stock' => 15,
            'descripcion' => 'Potente laptop con GPU dedicada',
        ];

        $response = $this->actingAs($this->user)->post('/productos/store', $data);
        $response->assertRedirect('/productos');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'nombre' => 'Laptop Gamer',
            'category_id' => $this->categoria->id,
            'proveedor_id' => $this->proveedor->id,
            'user_id' => $this->user->id,
            'stock' => 15,
            'activo' => 1,
        ]);
    }

    public function test_can_view_edit_product_page(): void
    {
        $producto = Producto::create([
            'user_id' => $this->user->id,
            'category_id' => $this->categoria->id,
            'proveedor_id' => $this->proveedor->id,
            'nombre' => 'Mouse USB',
            'precio_compra' => 5.0,
            'precio_venta' => 10.0,
            'stock' => 50,
        ]);

        $response = $this->actingAs($this->user)->get("/productos/edit/{$producto->id}");
        $response->assertStatus(200);
        $response->assertSee('Editar Producto');
        $response->assertSee('Mouse USB');
    }

    public function test_can_update_product(): void
    {
        $producto = Producto::create([
            'user_id' => $this->user->id,
            'category_id' => $this->categoria->id,
            'proveedor_id' => $this->proveedor->id,
            'nombre' => 'Teclado Simple',
            'precio_compra' => 10.0,
            'precio_venta' => 20.0,
            'stock' => 30,
        ]);

        $updateData = [
            'nombre' => 'Teclado Mecánico RGB',
            'category_id' => $this->categoria->id,
            'proveedor_id' => $this->proveedor->id,
            'precio_compra' => 25.0,
            'precio_venta' => 45.0,
            'stock' => 40,
            'descripcion' => 'Switches azules',
        ];

        $response = $this->actingAs($this->user)->put("/productos/update/{$producto->id}", $updateData);
        $response->assertRedirect('/productos');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'id' => $producto->id,
            'nombre' => 'Teclado Mecánico RGB',
            'stock' => 40,
        ]);
    }

    public function test_can_toggle_product_status_via_ajax(): void
    {
        $producto = Producto::create([
            'user_id' => $this->user->id,
            'category_id' => $this->categoria->id,
            'proveedor_id' => $this->proveedor->id,
            'nombre' => 'Monitor 24',
            'precio_compra' => 100.0,
            'precio_venta' => 150.0,
            'stock' => 10,
            'activo' => true,
        ]);

        // Cambiar a inactivo (0)
        $response = $this->actingAs($this->user)->get("/productos/cambiar-estado/{$producto->id}/0");
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'id' => $producto->id,
            'activo' => 0,
        ]);

        // Cambiar a activo (1)
        $response2 = $this->actingAs($this->user)->get("/productos/cambiar-estado/{$producto->id}/1");
        $response2->assertStatus(200);
        $response2->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'id' => $producto->id,
            'activo' => 1,
        ]);
    }

    public function test_can_view_show_and_delete_product(): void
    {
        $producto = Producto::create([
            'user_id' => $this->user->id,
            'category_id' => $this->categoria->id,
            'proveedor_id' => $this->proveedor->id,
            'nombre' => 'Cable HDMI',
            'precio_compra' => 2.0,
            'precio_venta' => 6.0,
            'stock' => 100,
        ]);

        $response = $this->actingAs($this->user)->get("/productos/show/{$producto->id}");
        $response->assertStatus(200);
        $response->assertSee('Eliminar Producto');
        $response->assertSee('Cable HDMI');

        $deleteResponse = $this->actingAs($this->user)->delete("/productos/destroy/{$producto->id}");
        $deleteResponse->assertRedirect('/productos');
        $deleteResponse->assertSessionHas('success');

        $this->assertDatabaseMissing('products', [
            'id' => $producto->id,
        ]);
    }
}
