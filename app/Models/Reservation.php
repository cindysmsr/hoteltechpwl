<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_number',
        'guest_id',
        'check_in_date',
        'check_out_date',
        'adults',
        'children',
        'status',
        'total_amount',
        'payment_status',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function reservationRooms(): HasMany
    {
        return $this->hasMany(ReservationRoom::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'reservation_rooms', 'reservation_id', 'room_id');
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'id', 'reservation_id');
    }
}
