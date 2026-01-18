<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','room_id','start_date','end_date','guest_count','status','total_amount'];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_amount' => 'decimal:2'
    ];
    public function room() { return $this->belongsTo(Room::class); }
    public function user() { return $this->belongsTo(\App\Models\User::class); }
    public function payment() { return $this->hasOne(Payment::class); }
}
