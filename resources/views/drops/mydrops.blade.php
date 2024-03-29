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

        <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md">
            <div class="w-2 bg-amber-400"></div>

            <div class="flex items-center px-2 py-3">
                <svg width="24" height="24" fill="#303133" class="kingdom-brun" viewBox="0 0 141.73 141.73"
                    background="white">
                    <path
                        d="M6.65 114.31h50.17c3.67 0 6.65 2.97 6.65 6.64 0 3.67-2.98 6.64-6.65 6.64H6.65c-3.67 0-6.65-2.97-6.65-6.64 0-3.67 2.98-6.64 6.65-6.64z">
                    </path>
                    <path
                        d="M135.63 80.92l-7.71-7.71c-1.05-1.05-2.2-1.94-3.41-2.69 3.5-.76 6.3-3.55 6.96-7.18l4.06-20.22v-.08c.29-1.56-.13-3.15-1.14-4.36-.14-.16-.28-.31-.43-.45l-4.1-4.1c-1-.99-2.35-1.55-3.77-1.55-1.17 0-2.29.38-3.22 1.1l-5.29 4.02-2.21-4.02c-.25-.45-.55-.86-.92-1.21l-4.1-4.1c-1-1.04-2.38-1.64-3.86-1.64-1.63 0-3.15.75-4.16 1.99-.11-2.75-1.1-5.08-2.74-6.73l-7.71-7.71c-1.69-1.77-4.1-2.81-6.94-2.81H62.09c-4.13 0-7.41 2.26-8.87 5.73l-3.08-3.08.02-.02c-1.65-1.65-3.91-2.64-6.48-2.64h-23.3c-3.25 0-5.82.92-7.63 2.73-1.73 1.73-2.62 4.11-2.62 7.06 0 2.11.55 4.41 1.16 6.59v.04l.03.04c1.38 4.55 1.64 13.36 1.64 27.03 0 14.96-.24 22.4-1.64 27.02v.05l-.03.05c-.61 2.21-1.16 4.37-1.16 6.59 0 2.95.88 5.33 2.62 7.06l7.83 7.83c1.81 1.81 4.38 2.73 7.63 2.73h23.3c4.03 0 7.3-2.43 8.66-6.05 2.11 4.1 4.67 7.67 7.71 10.68l7.71 7.71c1.92 1.92 4.04 3.64 6.34 5.11 6.69 4.28 15 6.55 24.04 6.55 2.69 0 5.39-.2 8.03-.58 8.46-1.25 15.53-5.06 20.45-11.01 4.76-5.78 7.29-13.32 7.29-21.78 0-7.03-2.45-12.38-6.1-15.97zM96.54 43.29c.76.57 1.84.34 2.31-.49l6.31-11.48c.59-1.08 2.14-1.08 2.73 0l6.31 11.48c.45.84 1.55 1.07 2.31.49l8.68-6.6c1.13-.86 2.72.12 2.47 1.51l-4.07 20.25a5.236 5.236 0 01-5.16 4.32h-23.8c-2.54 0-4.71-1.82-5.16-4.32L85.4 38.2c-.25-1.39 1.34-2.37 2.47-1.51l8.68 6.6zM105.6 118c-12.52 1.84-38.3.67-46.13-30.99v-.03c-2.88-11.65-6.94-21.62-11.58-21.62-.8 0-1.58.8-1.58 2.27 0 4.63.56 9.72 1.58 15.49.45 2.49 1.25 3.62 1.25 5.43 0 3.39-2.15 5.99-5.43 5.99H20.4c-4.52 0-6.34-2.27-6.34-5.88 0-1.69.45-3.51 1.02-5.54 1.58-5.2 1.81-13.12 1.81-28.16s-.34-23.3-1.81-28.16c-.56-2.03-1.02-3.96-1.02-5.54 0-3.62 1.81-5.88 6.34-5.88h23.3c3.28 0 5.43 2.6 5.43 5.99 0 1.81-.56 3.05-1.25 5.43-1.13 4.18-1.69 8.03-1.69 17.53 0 1.13.67 1.81 1.47 1.81.56 0 1.25-.34 1.92-1.02 4.07-4.41 5.43-6.34 8.14-10.52.8-1.13 1.25-2.71 1.25-4.29s-.45-3.28-1.47-4.87c-.8-1.13-1.13-2.6-1.13-4.07 0-3.05 1.81-5.99 5.77-5.99h22.85c3.85 0 5.65 2.82 5.65 5.99 0 1.92-.67 4.07-2.27 5.54-6.23 5.99-10.86 11.64-15.49 17.31-.68.8-1.25 2.03-1.25 3.05 0 .67.11 1.25.67 1.81 7.76 7.5 16.04 17.23 20.05 32.22.97 3.62 2.31 11.29 6.72 10.01 6.02-1.74 2.92-9-.99-9.39 0 0 3.99-10.29 16.52-10.29 7.7 0 15.38 5.88 15.38 17.42 0 15.15-8.92 26.65-24.39 28.92z">
                    </path>
                </svg>

                <div class="mx-3 flex flex-row justify-center items-center gap-3">
                    <p class="text-gray-600">Total de gain réclamés :</p>
                    <p class="text-xl font-flame">{{ $totalDrops }}</p>
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-16 md:grid-cols-2 xl:grid-cols-3">

            @foreach ($myDrops as $drop)
                <div class="w-full max-w-xs overflow-hidden bg-white rounded-xl shadow-xl">

                    <div class="relative flex flex-col justify-center items-center py-5 text-center">
                        <img class="qrcode object-cover w-auto h-auto rounded-md z-10 transition-all duration-300 transform"
                            src="http://chart.googleapis.com/chart?cht=qr&chl={{ $drop->qr_code }}&choe=UTF-8&chs=400x400&chld=M|2"
                            alt="">
                        <h3 class="absolute code text-center text-3xl py-36 mx-24 font-extrabold leading-6 z-0 text-gray-900 transition-all duration-300 transform opacity-0 scale-0"
                            id="modal-title">
                            {{ $drop->qr_code }}
                        </h3>
                    </div>

                    <div class="flex flex-col justify-center items-center py-5 text-center">
                        <div class="flex flex-row justify-center items-center gap-1">
                            <span class="text-2xl font-semibold text-gray-700 font-flame">
                                {{ $drop->points }}
                            </span>
                            <svg width="35" height="35" fill="#F7A800" class="crown pb-1" viewBox="0 0 24 24"
                                preserveAspectRatio="none">
                                <path
                                    d="M12.34 15.874c4.993 0 8.375 1.167 8.965 2.106-.94 1.28-4.59 2.22-8.964 2.22-4.375 0-8.053-.94-8.965-2.22.59-.939 3.945-2.106 8.965-2.106zM12.26 4.15c.134-.199.403-.199.537 0l3.704 6.347c.107.17.322.227.483.085l4.026-3.586c.188-.199.51-.028.51.256v9.534c-1.637-1.366-5.368-2.05-9.206-2.05-3.704 0-7.596.77-9.314 2.05V7.25c0-.284.295-.455.51-.284l4.402 3.728c.134.114.349.085.456-.086l3.892-6.46z"
                                    fill-rule="evenodd"></path>
                            </svg>
                        </div>

                        <span class="text-sm text-gray-700 ">{{ $drop->date }}</span>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

    <script>
        $(document).ready(function() {
            $('.qrcode').click(function() {
                $(this).next().toggleClass('opacity-0');
                $(this).next().toggleClass('scale-0');
                $(this).toggleClass('opacity-0');
                $(this).toggleClass('scale-0');
            });
            $('.code').click(function() {
                $(this).prev().toggleClass('opacity-0');
                $(this).prev().toggleClass('scale-0');
                $(this).toggleClass('opacity-0');
                $(this).toggleClass('scale-0');
            });
        });
    </script>

</x-app-layout>
