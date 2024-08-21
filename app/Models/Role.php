<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_type_id',
        'name',
        'description',
    ];

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}
