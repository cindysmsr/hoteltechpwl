<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['reservation', 'guest'])
            ->whereHas('reservation', function($query) {
                $query->where('guest_id', Auth::user()->guest->id);
            })
            ->latest()
            ->paginate(10);

        return view('guest.reviews.index', compact('reviews'));
    }
}