<div>
    <div
        class="container mx-auto bg-white  overflow-hidden mb-2 ">
        <!-- Image Slider -->
        <div class="container mx-auto py-6">
            <div data-hs-carousel='{
                "loadingClasses": "opacity-0",
                "dotsItemClasses": "hs-carousel-active:bg-blue-700 hs-carousel-active:border-blue-700 size-3 border border-gray-400 rounded-full cursor-pointer dark:border-neutral-600 dark:hs-carousel-active:bg-blue-500 dark:hs-carousel-active:border-blue-500",
                "isAutoPlay": true
              }'
                class="relative border border-gray-200 rounded-lg shadow-lg">
                <div class="hs-carousel relative overflow-hidden w-full min-h-96 bg-white rounded-lg ">
                    <div
                        class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700 opacity-0 ">
                        <div class="hs-carousel-slide">
                            <div class="flex  h-full bg-gray-100  dark:bg-neutral-900">
                                <img class="w-full h-full  object-cover"
                                    src="{{ asset('storage/images/slide/slide1.jpg') }}">
                            </div>
                        </div>
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-200  dark:bg-neutral-800">
                                <img class="w-full h-full  object-cover"
                                    src="{{ asset('storage/images/slide/slide2.jpg') }}">
                            </div>
                        </div>
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-300  dark:bg-neutral-700">
                                <img class="w-full h-full  object-cover"
                                    src="{{ asset('storage/images/slide/slide3.jpg') }}">
                            </div>
                        </div>
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-300  dark:bg-neutral-700">
                                <img class="w-full h-full  object-cover"
                                    src="{{ asset('storage/images/slide/slide4.jpg') }}">
                            </div>
                        </div>
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-300  dark:bg-neutral-700">
                                <img class="w-full h-full  object-cover"
                                    src="{{ asset('storage/images/slide/slide5.jpg') }}">
                            </div>
                        </div>
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-300  dark:bg-neutral-700">
                                <img class="w-full h-full  object-cover"
                                    src="{{ asset('storage/images/slide/slide6.jpg') }}">
                            </div>
                        </div>
                        <div class="hs-carousel-slide">
                            <div class="flex justify-center h-full bg-gray-300  dark:bg-neutral-700">
                                <img class="w-full h-full  object-cover"
                                    src="{{ asset('storage/images/slide/slide7.jpg') }}">
                            </div>
                        </div>

                    </div>
                </div>

                <button type="button"
                    class="hs-carousel-prev hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 start-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-s-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <span class="text-2xl" aria-hidden="true">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"></path>
                        </svg>
                    </span>
                    <span class="sr-only">Previous</span>
                </button>
                <button type="button"
                    class="hs-carousel-next hs-carousel-disabled:opacity-50 hs-carousel-disabled:pointer-events-none absolute inset-y-0 end-0 inline-flex justify-center items-center w-[46px] h-full text-gray-800 hover:bg-gray-800/10 focus:outline-none focus:bg-gray-800/10 rounded-e-lg dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                    <span class="sr-only">Next</span>
                    <span class="text-2xl" aria-hidden="true">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </span>
                </button>

                <div class="hs-carousel-pagination flex justify-center absolute bottom-3 start-0 end-0 space-x-2"></div>
            </div>
        </div>

        {{-- {{dd($duration)}} --}}
        <!-- Yacht Details -->
        <div class="p-4 text-center">
            <h3 class=" font-bold text-blue-900 whitespace-nowrap">S E A S C A P E 2</h3>
            <p class="text-gray-600 mt-2">Welcome to Seascape 2, your Gateway o unparalleted luxury in Phuket. This 2009
                Motor Yacht is not just a vessel;
                it's an experience With contemporary styling and exceptional natural light, Seascape 2 offers the
                perfect backdrop for unforgettable moments.</p>

        </div>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full border-collapse border border-gray-600">
                <thead>
                    <tr>
                        <th class="border border-gray-300 bg-blue-900 px-4 py-2 text-center text-white">Destination</th>
                        @foreach ($duration as $durations)
                            <th class="border border-gray-300 bg-blue-900 px-4 py-2 text-center text-white">
                                {{ \Carbon\Carbon::parse($durations->start_time)->locale('th')->isoFormat('D MMMM YYYY') }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach ($package as $packages)
                        <tr>
                            <th class="border border-gray-300 bg-blue-50 px-4 py-2 text-left" width="35%">
                                {{ $packages->name_boat }}
                            </th>
                            
                            @foreach ($duration as $durations)
                              
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    @if ($durations->start_time == $packages->start_time)
                                       {{ number_format($packages->prices[0]->regular )}} THB 
                                    @else
                                        -
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
        <div class="p-4 text-center bg-gray-100  border border-blue-100 rounded-lg shadow-md">
            <h4 class=" font-bold text-blue-900 whitespace-nowrap">This price includes</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                <p class="text-blue-600 font-bold"> Private tour</p>
                <p class="text-blue-600 font-bold"> Captain & Crew</p>
                <p class="text-blue-600 font-bold"> Lunch</p>
                <p class="text-blue-600 font-bold"> Softdrinks</p>
                <p class="text-blue-600 font-bold"> 24x beer</p>
                <p class="text-blue-600 font-bold"> Tropical Fruits</p>
                <p class="text-blue-600 font-bold"> Water trampoline</p>
                <p class="text-blue-600 font-bold"> 2x Paddle board</p>
                <p class="text-blue-600 font-bold"> Snorkelling equipment</p>
                <p class="text-blue-600 font-bold"> Towels</p>
                <p class="text-blue-600 font-bold"> Air condition</p>
                <p class="text-blue-600 font-bold"> Life jackets</p>
                <p class="text-blue-600 font-bold"> Soundsystem</p>
                <p class="text-blue-600 font-bold"> Accident insurance</p>
                <p class="text-blue-600 font-bold"> Taxi tranfers to the marina</p>
                <p class="text-blue-600 font-bold"> National park fees</p>
               
            </div>
            <p class="text-grey-600 font-bold">* The day charter price is quoted for 1-8 guest. </p>
            <p class="text-grey-600 font-bold">** No Lunch inclusive at half day charters </p>
        </div>
        


    </div>
</div>
