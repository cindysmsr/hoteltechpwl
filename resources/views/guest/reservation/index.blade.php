@extends('layouts.guest')

@section('title', 'Reservasi Kamar Hotel')
<!-- hallo -->
 <!-- world -->
@section('content')
<!-- Hero Section -->
<section class="relative bg-cover bg-center py-32 text-white text-center" id="beranda" style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3)), url('{{ asset('img/' . $heroData['image']) }}')">
    <div class="max-w-7xl mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">{{ $heroData['title'] }}</h1>
            <p class="text-lg mb-8">{{ $heroData['description'] }}</p>
            <a href="#rooms" class="bg-cyan-500 text-white px-6 py-3 rounded hover:bg-cyan-600 transition-colors inline-block font-medium">Lihat Kamar</a>
        </div>
    </div>
</section>

<!-- Search Form -->
<div class="max-w-7xl mx-auto px-4">
    <div class="bg-white p-8 rounded-lg shadow-lg relative -mt-12 z-10">
        <form action="{{ route('guest.reservations.search') }}" method="GET">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <label for="check_in_date" class="block mb-2 font-medium">Check-in</label>
                    <input type="date" id="check_in_date" name="check_in_date" required value="{{ old('check_in_date', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}"
                        class="w-full p-3 border border-gray-300 rounded text-base focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>
                <div>
                    <label for="check_out_date" class="block mb-2 font-medium">Check-out</label>
                    <input type="date" id="check_out_date" name="check_out_date" required value="{{ old('check_out_date', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        class="w-full p-3 border border-gray-300 rounded text-base focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>
                <div>
                    <label for="adults" class="block mb-2 font-medium">Jumlah Tamu</label>
                    <select id="adults" name="adults"
                            class="w-full p-3 border border-gray-300 rounded text-base focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}">{{ $i }} Tamu</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="room_type" class="block mb-2 font-medium">Tipe Kamar</label>
                    <select id="room_type" name="room_type"
                            class="w-full p-3 border border-gray-300 rounded text-base focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Semua Tipe</option>
                        @foreach ($roomTypes as $roomType)
                            <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="bg-cyan-500 text-white w-full p-3 rounded font-medium hover:bg-cyan-600 transition-colors">Cari Kamar</button>
        </form>
    </div>
</div>

<!-- Room Types Section -->
<section class="py-20" id="rooms">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Pilihan Tipe Kamar</h2>
            <p class="text-gray-600 mt-3">Temukan kamar yang sesuai dengan kebutuhan dan budget Anda</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($roomTypes as $roomType)
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:-translate-y-2 transition-transform duration-300">
                <div class="h-48 overflow-hidden">
                    @if ($roomType->img)
                        <img src="{{ asset( 'storage/' . $roomType->img) }}" alt="{{ $roomType->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    @else
                        <img src="https://placehold.co/400x300" alt="{{ $roomType->name }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $roomType->name }}</h3>
                    <p class="text-lg text-cyan-500 font-semibold mb-4">Rp {{ number_format($roomType->price, 0, ',', '.') }} / malam</p>
                    <ul class="mb-6 space-y-1">
                        @php
                            $amenitiesArray = old('amenities', is_array($roomType->amenities) ? $roomType->amenities : json_decode($roomType->amenities, true) ?? []);
                        @endphp
                        @foreach ($amenitiesArray as $amenity)
                            <li class="text-gray-600 before:content-['✓'] before:text-cyan-500 before:mr-2">{{ $amenity }}</li>
                        @endforeach
                        <li class="text-gray-600 before:content-['✓'] before:text-cyan-500 before:mr-2">Kapasitas: {{ $roomType->capacity }} orang</li>
                    </ul>
                    <a href="{{ route('room.detail', $roomType->id) }}" class="bg-cyan-500 text-white py-2 px-4 rounded hover:bg-cyan-600 transition-colors inline-block">Lihat Detail</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- About Hotel Section -->
<section class="py-20 bg-gray-50" id="about">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Tentang {{ config('app.name') }}</h2>
                <div class="space-y-4">
                    @foreach ($about['description'] as $paragraph)
                        <p class="text-gray-600">{{ $paragraph }}</p>
                    @endforeach
                </div>
                <p class="mt-4 text-gray-600">Fasilitas hotel kami meliputi:</p>
                <ul class="mt-2 space-y-1">
                    @foreach ($about['facilities'] as $facility)
                        <li class="text-gray-600 before:content-['✓'] before:text-cyan-500 before:mr-2">{{ $facility }}</li>
                    @endforeach
                </ul>
            </div>
            <div>
                @if (isset($about['image']))
                    <img src="{{ asset('img/' . $about['image']) }}" alt="{{ config('app.name') }}" class="w-full rounded-lg">
                @else
                    <img src="https://placehold.co/600x400" alt="{{ config('app.name') }}" class="w-full rounded-lg">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-20 bg-blue-50" id="testimonials">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Testimoni Tamu</h2>
            <p class="text-gray-600 mt-3">Apa kata mereka tentang pengalaman menginap di {{ config('app.name') }}</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($testimonials as $testimonial)
            <div class="bg-white p-8 rounded-lg shadow">
                <div class="italic text-gray-700 mb-6">
                    <p>"{{ $testimonial->comment }}"</p>
                </div>
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                        <img src="https://ui-avatars.com/api/?name={{ $testimonial->guest->name }}" alt="{{ $testimonial->guest->name }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-1">{{ $testimonial->guest->name }}</h4>
                        <p class="text-gray-600 text-sm">{{ $testimonial->reservation->city }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Hidden search form for direct searching -->
<form id="search-form" action="{{ route('guest.reservations.search') }}" method="POST" class="hidden">
    @csrf
    <input type="hidden" name="check_in_date" value="{{ date('Y-m-d') }}">
    <input type="hidden" name="check_out_date" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
    <input type="hidden" name="adults" value="1">
    <input type="hidden" name="room_type" value="Semua Tipe">
</form>
@endsection