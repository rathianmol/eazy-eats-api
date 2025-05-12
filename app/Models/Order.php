<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes; // Enables soft deletes

    protected $fillable = ['user_id', 'meals', 'total_price', 'status'];

    // Ensure the 'meals' column is cast to an array
    protected $casts = [
        'meals' => 'array',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
