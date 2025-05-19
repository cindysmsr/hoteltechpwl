<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\RoomType;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();

        $heroData = [
            'title' => 'Temukan Kenyamanan Menginap Terbaik',
            'description' => 'Nikmati pengalaman menginap yang tak terlupakan dengan berbagai pilihan kamar yang sesuai dengan kebutuhan Anda',
            'image' => 'header.png'
        ];

        $about = [
            'description' => [
                'HotelTech adalah hotel bintang 5 yang terletak di jantung kota Jakarta. Dengan lokasi strategis yang dekat dengan pusat bisnis dan tempat wisata populer, HotelTech menawarkan pengalaman menginap yang tak terlupakan bagi wisatawan bisnis maupun liburan.',
                'Didirikan pada tahun 2010, HotelTech telah melayani ribuan tamu dari berbagai belahan dunia. Kami berkomitmen untuk memberikan pelayanan terbaik dengan fasilitas modern dan kenyamanan premium.'
            ],
            'facilities' => [
                'Kolam renang infinity dengan pemandangan kota',
                'Restoran dengan masakan internasional',
                'Pusat kebugaran 24 jam',
                'Spa dan pusat kesehatan',
                'Ruang konferensi dan ballroom',
                'Parkir valet',
                'Layanan concierge 24 jam'
            ],
            'image' => "feature.png"
        ];

        $testimonials = Review::
            get()
            ->unique('guest_id');
            

        $contactInfo = [
            'address' => 'Jl. Jendral Sudirman No. 123, Jakarta Pusat, 10220, Indonesia',
            'phone' => '(021) 123-4567',
            'email' => 'info@hoteltech.com'
        ];

        $socialMedia = [
            'facebook' => 'https://facebook.com/hoteltech',
            'instagram' => 'https://instagram.com/hoteltech',
            'twitter' => 'https://twitter.com/hoteltech',
            'linkedin' => 'https://linkedin.com/company/hoteltech'
        ];

        return view('guest.reservation.index', [
            'roomTypes' => $roomTypes,
            'heroData' => $heroData,
            'about' => $about,
            'testimonials' => $testimonials,
            'contactInfo' => $contactInfo,
            'socialMedia' => $socialMedia
        ]);
    }
}
