<x-app-layout>

    <div class="flex flex-col items-center justify-center w-full mx-auto py-24 gap-12">

        <div class="flex items-center justify-center">
            <div class="inline-flex bg-white border divide-x rounded-lg  rtl:flex-row-reverse  ">
                <a href="{{ route('drops.crowns') }}"
                    class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 @if (Route::currentRouteName() == 'drops.crowns' || Route::currentRouteName() == 'drops.index') bg-gray-100 @endif sm:text-sm hover:bg-gray-100">
                    Couronnes
                </a>
                <a href="{{ route('drops.coupons') }}"
                    class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 @if (Route::currentRouteName() == 'drops.coupons') bg-gray-100 @endif sm:text-sm hover:bg-gray-100">
                    Coupons
                </a>
                <a href="{{ route('drops.myDrops') }}"
                    class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 @if (Route::currentRouteName() == 'drops.myDrops') bg-gray-100 @endif sm:text-sm hover:bg-gray-100">
                    Mes drops
                </a>
            </div>
        </div>

        @if (Request::get('qrcode'))
            <div x-data="{ isOpen: true }" class="relative flex justify-center">
                <button @click="isOpen = true"
                    class="px-6 py-2 mx-auto tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                    Voir le QR CODE
                </button>

                <div x-show="isOpen" x-transition:enter="transition duration-300 ease-out"
                    x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                    x-transition:leave="transition duration-150 ease-in"
                    x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                    x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                    class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                    aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                            aria-hidden="true">&#8203;</span>

                        <div
                            class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-2xl shadow-black sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                            <div class="relative flex flex-col justify-center items-center text-center">
                                <img class="qrcode object-cover w-auto h-auto rounded-md transition-all duration-300 transform"
                                    src="http://chart.googleapis.com/chart?cht=qr&chl={{ Request::get('qrcode') }}&choe=UTF-8&chs=400x400&chld=M|2"
                                    alt="">
                                <h3 class="absolute code text-center text-3xl py-44 font-extrabold leading-6 text-gray-900 transition-all duration-300 transform opacity-0"
                                    id="modal-title">
                                    {{ Request::get('qrcode') }}
                                </h3>
                            </div>
                            <div>
                                <div class="flex flex-row justify-center items-center mt-3 text-center sm:mt-5">
                                    <h3 class="text-3xl font-extrabold leading-6 text-gray-900" id="modal-title">
                                        {{ Request::get('reward') }}
                                    </h3>
                                    <svg width="35" height="35" fill="#F7A800" class="pb-1" viewBox="0 0 24 24"
                                        preserveAspectRatio="none">
                                        <path
                                            d="M12.34 15.874c4.993 0 8.375 1.167 8.965 2.106-.94 1.28-4.59 2.22-8.964 2.22-4.375 0-8.053-.94-8.965-2.22.59-.939 3.945-2.106 8.965-2.106zM12.26 4.15c.134-.199.403-.199.537 0l3.704 6.347c.107.17.322.227.483.085l4.026-3.586c.188-.199.51-.028.51.256v9.534c-1.637-1.366-5.368-2.05-9.206-2.05-3.704 0-7.596.77-9.314 2.05V7.25c0-.284.295-.455.51-.284l4.402 3.728c.134.114.349.085.456-.086l3.892-6.46z"
                                            fill-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="mt-5 sm:flex sm:items-center sm:-mx-2">
                                <button id="switchButton"
                                    class="w-full px-4 py-2 mt-4 text-sm font-medium tracking-wide text-white capitalize transition-all duration-300 transform bg-blue-600 rounded-md sm:mt-0 sm:w-1/2 sm:mx-2 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                                    Voir le code
                                </button>
                                <button @click="isOpen = false"
                                    class="w-full px-4 py-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:w-1/2 sm:mx-2 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
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


                            <form action="{{ route('drops.getCoupon') }}" method="POST">
                                @csrf
                                <input type="hidden" name="coupon" value="{{ $coupon->label }}">
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
    </div>

    <script>
        $('#switchButton').click(function() {
            if ($('.qrcode').hasClass('opacity-0')) {
                $('#switchButton').text('Voir le code');
                $('.qrcode').removeClass('opacity-0');
                $('.qrcode').removeClass('scale-0');
                $('.code').addClass('opacity-0');
                $('.code').addClass('scale-0');
            } else {
                $('#switchButton').text('Voir le QR Code');
                $('.qrcode').addClass('opacity-0');
                $('.qrcode').addClass('scale-0');
                $('.code').removeClass('opacity-0');
                $('.code').removeClass('scale-0');
            }
    
        });
    </script>
</x-app-layout>
