<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{
    use HasFactory;

    protected $fillable = ['name','visible'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
