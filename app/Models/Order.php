<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'status'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Placeholder for meals relationship (to be added later)
    public function meals()
    {
        return $this->belongsToMany(Meal::class)->withPivot('quantity');
    }
}
