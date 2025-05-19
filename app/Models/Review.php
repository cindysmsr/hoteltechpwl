<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 
        'guest_id', 
        'rating', 
        'comment', 
        'staff_rating', 
        'cleanliness_rating', 
        'comfort_rating', 
        'would_recommend'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}