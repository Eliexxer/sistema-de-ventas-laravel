<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "products";

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'precio_compra',
        'stock',
        'activo',
        'user_id',
        'category_id',
        'proveedor_id',
    ];

    public function category()
    {
        return $this->belongsTo(Categoria::class, 'category_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
