<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $attributes = [
        'precioSugerido' => 0,
    ];
    // $allowedStatuses = [TaskStatus::PENDING, TaskStatus::IN_PROGRESS, TaskStatus::COMPLETED];
    // if (!in_array($value, $allowedStatuses)) {
    //     throw new \InvalidArgumentException("Invalid status");
    // }
    // protected $fillable = ['codigo', 'descripcion', 'precioSugerido', 'idCategoria', 'aplicaStock'];
}
