<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['number','type','description','price','capacity','features','image', 'images'];
    protected $casts = [
        'features' => 'array',
        'images' => 'array',
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
    // new method to check availability
    public function isAvailable(?string $from = null, ?string $to = null): bool
{
    $query = $this->bookings()
        ->whereIn('status', ['pending', 'confirmed', 'checked_in']);

    if ($from && $to) {
        // Check if any booking overlaps the given date range
        $query->where('start_date', '<', $to)
              ->where('end_date', '>', $from);
    } else {
        // No dates given — check if booked right now
        $query->where('start_date', '<', now()->addDays(1))
              ->where('end_date', '>', now());
    }

    return !$query->exists();
}
}
