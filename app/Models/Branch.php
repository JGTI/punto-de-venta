<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_type_id',
        'name',
        'address',
        'phone',
        'email',
        'active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }
}
