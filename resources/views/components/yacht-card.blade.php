<div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col md:flex-row w-full">
        <div class="md:flex-shrink-0">
            <img class="h-full w-full object-cover md:w-48" src="{{ asset('storage/package/' . $image) }}" alt="{{ $nameboat }}">
        </div>
        <div class="p-4">
            <h3 class="text-lg font-bold">{{ $nameboat }}</h3>
            <p class="mt-2 text-gray-600">{{ $description }}</p>
            <div class="mt-4">
                <span class="text-gray-900 font-bold">Max Guests:</span> {{ $max }}
            </div>
            <div class="mt-2">
                <span class="text-gray-900 font-bold">Price:</span> {{ number_format($price) }} THB
            </div>
            <!-- เพิ่มปุ่มจอง -->
            <div class="mt-4">
                <a href="{{ route('booking.create', ['package_id' => $packageid, 'date' => $date, 'datereturn' => $datereturn]) }}" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                    Book Now
                </a>
            </div>
        </div>
    </div>
    

</div>