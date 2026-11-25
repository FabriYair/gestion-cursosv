<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'descripcion',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    // Cada pedido pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
