<x-app-layout>

    <div class="flex flex-col items-center justify-center w-full max-w-sm mx-auto py-24 gap-28">

        <div class="flex flex-row items-center justify-center w-full max-w-sm mx-auto">

            <div class="flex flex-col items-center justify-center w-full max-w-sm mx-auto mt-24">

                <x-palier :points="$preferedReward" />


                <form action="{{ route('drops.getReward') }}" method="POST">
                    @csrf
                    <div class="w-56 -mt-10 overflow-hidden bg-white rounded-lg shadow-lg md:w-80">
                        <h3 class="py-2 font-bold tracking-wide text-center text-gray-800 uppercase">Récompense préférée
                            {{ $totalPreferedReward }} Drops</h3>

                        <div class="flex items-center justify-between px-3 py-2 bg-gray-200">
                            <span class="flex flex-row items-center font-bold text-gray-800">{{ $preferedReward }}
                                <svg width="35" height="35" fill="#F7A800" class="pb-1" viewBox="0 0 24 24"
                                    preserveAspectRatio="none">
                                    <path
                                        d="M12.34 15.874c4.993 0 8.375 1.167 8.965 2.106-.94 1.28-4.59 2.22-8.964 2.22-4.375 0-8.053-.94-8.965-2.22.59-.939 3.945-2.106 8.965-2.106zM12.26 4.15c.134-.199.403-.199.537 0l3.704 6.347c.107.17.322.227.483.085l4.026-3.586c.188-.199.51-.028.51.256v9.534c-1.637-1.366-5.368-2.05-9.206-2.05-3.704 0-7.596.77-9.314 2.05V7.25c0-.284.295-.455.51-.284l4.402 3.728c.134.114.349.085.456-.086l3.892-6.46z"
                                        fill-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input type="number" name="reward" class="hidden" value="{{ $preferedReward }}">
                            <button
                                class="px-2 py-1 text-xs font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">Récuperer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-white rounded-xl">
            <div class="container px-6 py-8 mx-auto">
                <p class="text-xl text-center text-gray-500">
                    Choisissez votre gain
                </p>

                <h1
                    class="flex flex-row justify-center mt-4 text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl">
                    <svg width="35" height="35" fill="#F7A800" class="crown" viewBox="0 0 24 24"
                        preserveAspectRatio="none">
                        <path
                            d="M12.34 15.874c4.993 0 8.375 1.167 8.965 2.106-.94 1.28-4.59 2.22-8.964 2.22-4.375 0-8.053-.94-8.965-2.22.59-.939 3.945-2.106 8.965-2.106zM12.26 4.15c.134-.199.403-.199.537 0l3.704 6.347c.107.17.322.227.483.085l4.026-3.586c.188-.199.51-.028.51.256v9.534c-1.637-1.366-5.368-2.05-9.206-2.05-3.704 0-7.596.77-9.314 2.05V7.25c0-.284.295-.455.51-.284l4.402 3.728c.134.114.349.085.456-.086l3.892-6.46z"
                            fill-rule="evenodd"></path>
                    </svg>
                    Couronnes
                    <svg width="35" height="35" fill="#F7A800" class="crown" viewBox="0 0 24 24"
                        preserveAspectRatio="none">
                        <path
                            d="M12.34 15.874c4.993 0 8.375 1.167 8.965 2.106-.94 1.28-4.59 2.22-8.964 2.22-4.375 0-8.053-.94-8.965-2.22.59-.939 3.945-2.106 8.965-2.106zM12.26 4.15c.134-.199.403-.199.537 0l3.704 6.347c.107.17.322.227.483.085l4.026-3.586c.188-.199.51-.028.51.256v9.534c-1.637-1.366-5.368-2.05-9.206-2.05-3.704 0-7.596.77-9.314 2.05V7.25c0-.284.295-.455.51-.284l4.402 3.728c.134.114.349.085.456-.086l3.892-6.46z"
                            fill-rule="evenodd"></path>
                    </svg>
                </h1>

                <form action="{{ route('drops.getReward') }}" method="POST">
                    @csrf
                    <div class="mt-6 space-y-8 xl:mt-12">
                        @foreach ($rewards as $reward)
                            <div class="form-control">
                                <label class="label cursor-pointer">
                                    <input type="radio" value="{{ $reward->points }}" name="reward" class="hidden" />
                                    <span
                                        class="label-text reward flex items-center justify-between max-w-2xl px-8 py-4 mx-auto border rounded-xl">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-gray-400 sm:h-9 sm:w-9 transition-all duration-300 transform"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>

                                            <div class="flex flex-row items-center mx-5">
                                                <h2
                                                    class="text-lg font-medium text-gray-700 sm:text-2xl transition-all duration-300 transform">
                                                    {{ $reward->points }}</h2>
                                                <svg width="35" height="35" fill="#F7A800" class="pb-1"
                                                    viewBox="0 0 24 24" preserveAspectRatio="none">
                                                    <path
                                                        d="M12.34 15.874c4.993 0 8.375 1.167 8.965 2.106-.94 1.28-4.59 2.22-8.964 2.22-4.375 0-8.053-.94-8.965-2.22.59-.939 3.945-2.106 8.965-2.106zM12.26 4.15c.134-.199.403-.199.537 0l3.704 6.347c.107.17.322.227.483.085l4.026-3.586c.188-.199.51-.028.51.256v9.534c-1.637-1.366-5.368-2.05-9.206-2.05-3.704 0-7.596.77-9.314 2.05V7.25c0-.284.295-.455.51-.284l4.402 3.728c.134.114.349.085.456-.086l3.892-6.46z"
                                                        fill-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>

                                        <h2
                                            class="text-2xl font-semibold text-gray-500 sm:text-3xl transition-all duration-300 transform">
                                            {{ $reward->total }} <span
                                                class="text-base font-medium transition-Z duration-300 transform">
                                                @if ($reward->total > 1)
                                                    Restants
                                                @else
                                                    Restant
                                                @endif
                                            </span></h2>
                                    </span>
                                </label>
                            </div>
                        @endforeach

                        <div class="flex justify-center">
                            <button
                                class="px-8 py-2 tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                                Récuperer
                            </button>
                        </div>
                    </div>
                </form>
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
                            class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                            <div>
                                <img class="qrcode object-cover w-full h-full rounded-md transition-all duration-300 transform"
                                    src="http://chart.googleapis.com/chart?cht=qr&chl={{ Request::get('qrcode') }}&choe=UTF-8&chs=400x400&chld=M|2"
                                    alt="">
                                <h3 class="code text-center text-3xl py-44 font-extrabold leading-6 text-gray-900 hidden transition-all duration-300 transform"
                                    id="modal-title">
                                    {{ Request::get('qrcode') }}
                                </h3>
                            </div>
                            <div>
                                <div class="flex flex-row justify-center items-center mt-3 text-center sm:mt-5">
                                    <h3 class="text-3xl font-extrabold leading-6 text-gray-900" id="modal-title">
                                        {{ Request::get('reward') }}
                                    </h3>
                                    <svg width="35" height="35" fill="#F7A800" class="pb-1"
                                        viewBox="0 0 24 24" preserveAspectRatio="none">
                                        <path
                                            d="M12.34 15.874c4.993 0 8.375 1.167 8.965 2.106-.94 1.28-4.59 2.22-8.964 2.22-4.375 0-8.053-.94-8.965-2.22.59-.939 3.945-2.106 8.965-2.106zM12.26 4.15c.134-.199.403-.199.537 0l3.704 6.347c.107.17.322.227.483.085l4.026-3.586c.188-.199.51-.028.51.256v9.534c-1.637-1.366-5.368-2.05-9.206-2.05-3.704 0-7.596.77-9.314 2.05V7.25c0-.284.295-.455.51-.284l4.402 3.728c.134.114.349.085.456-.086l3.892-6.46z"
                                            fill-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="mt-5 sm:flex sm:items-center sm:-mx-2">
                                <button @click="isOpen = false"
                                    class="w-full px-4 py-2 text-sm font-medium tracking-wide text-gray-700 capitalize transition-colors duration-300 transform border border-gray-200 rounded-md sm:w-1/2 sm:mx-2 hover:bg-gray-100 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-40">
                                    Fermer
                                </button>

                                <button id="switchButton"
                                    class="w-full px-4 py-2 mt-4 text-sm font-medium tracking-wide text-white capitalize transition-all duration-300 transform bg-blue-600 rounded-md sm:mt-0 sm:w-1/2 sm:mx-2 hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40">
                                    Voir le code
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>


    <script>
        $(document).ready(function() {
            var rewards = $('.reward');
            rewards.click(function() {
                rewards.each(function() {
                    $(this).removeClass('border-blue-500');
                    $(this).children().first().children().first().removeClass('text-blue-600');
                    $(this).children().first().children().first().next().children().first()
                        .removeClass(
                            'text-blue-600');
                    $(this).children().first().children().first().next().children().first()
                        .removeClass(
                            'font-extrabold');
                    $(this).children().last().removeClass('text-blue-600');
                    $(this).children().last().removeClass('font-extrabold');
                    $(this).children().last().children().first().removeClass('text-blue-600');
                    $(this).removeClass('selected');
                });

                $(this).addClass('border-blue-500');
                $(this).children().first().children().first().addClass('text-blue-600');
                $(this).children().first().children().first().next().children().first().addClass(
                    'text-blue-600');
                $(this).children().first().children().first().next().children().first().addClass(
                    'font-extrabold');
                $(this).children().last().addClass('text-blue-600');
                $(this).children().last().addClass('font-extrabold');
                $(this).children().last().children().first().addClass('text-blue-600');
                $(this).addClass('selected');
            });

            $('#switchButton').click(function() {
                if ($('.qrcode').hasClass('hidden')) {
                    $('#switchButton').text('Voir le code');
                    $('.qrcode').removeClass('hidden');
                    $('.code').addClass('hidden');
                } else {
                    $('#switchButton').text('Voir le QR Code');
                    $('.qrcode').addClass('hidden');
                    $('.code').removeClass('hidden');
                }

            });
        });
    </script>

</x-app-layout>
