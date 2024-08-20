<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'sub_menu_name',
        'subsub_menu_name',
        'route',
        'status',
        'roles',
        'icon',
        'order'
    ];

    // Opcional: si necesitas ordenar por este campo por defecto
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }
}
