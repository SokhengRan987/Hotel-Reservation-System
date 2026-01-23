<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['number','type','description','price','capacity','features','image'];
    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2'
    ];
    
    // Alias max_adults to capacity for backward compatibility
    public function getMaxAdultsAttribute()
    {
        return $this->attributes['capacity'] ?? 1;
    }
     public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
