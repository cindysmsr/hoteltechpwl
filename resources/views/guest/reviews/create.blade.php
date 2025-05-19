@extends('layouts.guest')

@section('title', 'Buat Ulasan')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 p-6 text-white">
                <div class="flex items-center">
                    <div class="mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Beri Ulasan Penginapan Anda</h1>
                        <p class="mt-1">Reservasi No. {{ $reservation->reservation_number }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Review Form -->
            <form action="{{ route('guest.reservations.reviewStore', $reservation->id) }}" method="POST" class="p-6">
                @csrf
                
                <div class="space-y-6">
                    <!-- Overall Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Penilaian Keseluruhan
                        </label>
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="inline-flex items-center">
                                    <input type="radio" name="rating" value="{{ $i }}" 
                                        class="form-radio h-5 w-5 text-blue-600" 
                                        {{ old('rating') == $i ? 'checked' : '' }} 
                                        required>
                                    <span class="ml-2 text-gray-700">{{ $i }} Bintang</span>
                                </label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Detailed Ratings -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Staff Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Pelayanan Staf
                            </label>
                            <select name="staff_rating" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">Pilih Penilaian</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('staff_rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} Bintang
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Cleanliness Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kebersihan
                            </label>
                            <select name="cleanliness_rating" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">Pilih Penilaian</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('cleanliness_rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} Bintang
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Comfort Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kenyamanan
                            </label>
                            <select name="comfort_rating" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                <option value="">Pilih Penilaian</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('comfort_rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} Bintang
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Recommend Checkbox -->
                    <div class="mt-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="would_recommend" value="1" 
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                {{ old('would_recommend') ? 'checked' : '' }}>
                            <label class="ml-2 block text-sm text-gray-900">
                                Saya akan merekomendasikan hotel ini kepada teman atau keluarga
                            </label>
                        </div>
                    </div>

                    <!-- Comment -->
                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700">
                            Komentar Tambahan (Opsional)
                        </label>
                        <textarea id="comment" name="comment" rows="4" 
                            class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                            placeholder="Bagikan pengalaman menginap Anda">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm">
                            Kirim Ulasan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection