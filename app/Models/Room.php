<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['number','type','description','price','capacity','features'];
    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2'
    ];
     public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
