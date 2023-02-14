<x-app-layout>

    <div class="flex items-center justify-center my-10">
        <div class="inline-flex bg-white border divide-x rounded-lg  rtl:flex-row-reverse  ">
            <a href="{{ route('drops.crowns') }}"
                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 @if (Route::currentRouteName() != 'drops.coupons') bg-gray-100 @endif sm:text-sm hover:bg-gray-100">
                Couronnes
            </a>
            <a href="{{ route('drops.coupons') }}"
                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 @if (Route::currentRouteName() == 'drops.coupons') bg-gray-100 @endif sm:text-sm hover:bg-gray-100">
                Coupons
            </a>
        </div>
    </div>

    <div class="bg-white">
        <div class="container px-6 py-8 mx-auto">
            <p class="text-xl text-center text-gray-500">
                Choisissez votre gain
            </p>

            <h1
                class="flex flex-row justify-center mt-4 text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl">
                <svg class="w-10 h-10 pb-1" xmlns="http://www.w3.org/2000/svg" fill="#F7A800" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="white" aria-hidden="true">
                    <path stroke-linecap="round" fill-rule="evenodd" stroke-linejoin="round"
                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z">
                    </path>
                </svg>
                Coupons
                <svg class="w-10 h-10 pb-1" xmlns="http://www.w3.org/2000/svg" fill="#F7A800" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="white" aria-hidden="true">
                    <path stroke-linecap="round" fill-rule="evenodd" stroke-linejoin="round"
                        d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z">
                    </path>
                </svg>
            </h1>

            @if ($coupons == '[]')
                    <div class="flex flex-col items-center justify-center w-full p-8 space-y-8 text-center">
                        <p class="text-lg font-semibold text-gray-800 uppercase">Aucun coupon disponible</p>
                    </div>
                @endif
            <div class="grid grid-cols-1 gap-8 mt-6 xl:mt-12 xl:gap-12 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($coupons as $coupon)
                    <div class="w-full p-8 space-y-8 text-center border border-gray-200 rounded-lg">
                        <p class="text-lg font-semibold text-gray-800 uppercase">{{ $coupon->label }}</p>

                        <x-coupon :coupon="$coupon->label" />

                        <div class="flex flex-row justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                              </svg>
                              
                            <h2 class="font-semibold text-gray-800">
                                {{ $coupon->total }}
                            </h2>
                            <p class="text-sm text-gray-500">
                                @if ($coupon->total > 1)
                                    coupons
                                @else
                                    coupon
                                @endif
                        </div>

                        <div class="flex flex-row justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-pulse">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-semibold text-gray-800">{{ $coupon->remaining_days }}</p>
                            <p class="text-sm text-gray-500">
                                jours @if ($coupon->remaining_days > 1)
                                    restants
                                @else
                                    restant
                                @endif
                            </p>
                        </div>


                        <form action="{{ route('drops.coupons') }}" method="POST">
                            @csrf
                            <input type="hidden" name="coupon_id" value="{{ $coupon->id }}">
                            <button
                                class="w-full px-4 py-2 mt-10 tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                                Récupérer
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>
