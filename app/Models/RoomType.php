<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'room_category_id',
        'category',
        'bed_type',
        'description',
        'price_per_night',
        'max_guests',
        'size_sqft',
        'rating',
        'image_url',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'rating'          => 'decimal:1',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function roomCategory()
    {
        return $this->belongsTo(RoomCategory::class);
    }

    public function availableRooms()
    {
        return $this->hasMany(Room::class)->where('status', 'available');
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Room::class);
    }
}
