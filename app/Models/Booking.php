<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'check_in'    => 'date',
        'check_out'   => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function getNightsAttribute()
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    public function getReferenceAttribute(): string
    {
        return 'LH-' . $this->created_at->format('Y') . '-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
