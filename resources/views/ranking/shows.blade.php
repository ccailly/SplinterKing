<x-app-layout>
    <section class="bg-white">
        <div class="container px-6 py-10 mx-auto">
            <h1 class="text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl pb-6">Classements</h1>

            <div class="flex items-center justify-center">
                <div class="inline-flex bg-white border divide-x rounded-lg  rtl:flex-row-reverse  ">
                    <a href="{{ route('ranking.wheels') }}"
                        class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 @if (Route::currentRouteName() != 'ranking.eaters') bg-gray-100 @endif sm:text-sm hover:bg-gray-100">
                        Mineurs
                        de Roulettes
                    </a>
                    <a href="{{ route('ranking.eaters') }}"
                        class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 @if (Route::currentRouteName() == 'ranking.eaters') bg-gray-100 @endif sm:text-sm hover:bg-gray-100">
                        Mangeurs
                    </a>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-8 mt-8 xl:mt-16 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($datas as $data)
                    <div class="flex flex-col items-center">
                        <img class="object-cover w-1/2 rounded-xl aspect-square"
                            src="{{ Vite::asset('resources/images/maitresplinter_avatar.png') }}" alt="avatar">
                        <h1 class="mt-4 text-2xl font-semibold text-gray-700 capitalize">#{{ $data->user_rank }}
                            {{ $data->name }}</h1>

                        <p class="mt-2 text-gray-500 capitalize">{{ $data->total }} @if (Route::currentRouteName() == 'ranking.eaters')
                                comptes mangés
                            @else
                                roulettes tournées
                            @endif
                        </p>

                        <div class="relative inline-block">
                            <span class="relative inline-flex mt-2">
                                <span
                                    class="info-badge inline-flex items-center px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full transition ease-in-out duration-150 ring-1 ring-slate-900/10/20 cursor-pointer">{{ $data->info }}
                                </span>
                                <span class="flex absolute h-3 w-3 top-0 right-0 -mt-1 -mr-1">
                                    @if (Route::currentRouteName() != 'ranking.eaters')
                                        <span
                                            class="animate-ping absolute inline-flex h-full w-full rounded-full @if ($data->info == 'Running') bg-green-400 @else bg-red-400 @endif opacity-75"></span>
                                        <span
                                            class="relative inline-flex rounded-full h-3 w-3 @if ($data->info == 'Running') bg-green-500 @else bg-red-500 @endif"></span>
                                    @endif
                                </span>
                            </span>
                            <p
                                class="info-tooltip absolute flex items-center justify-center w-48 text-gray-600 bg-white rounded-lg shadow-lg -left-16 top-10 shadow-gray-200 ring-1 ring-slate-600 opacity-0">
                                <span class="truncate text-xs">
                                    @if (Route::currentRouteName() == 'ranking.eaters')
                                        @if ($data->info == 'Aucun')
                                            Aucun gain retiré
                                        @else
                                            Gain préféré de {{ $data->name }}
                                        @endif
                                    @else
                                        @if ($data->info == 'Running')
                                            {{ $data->name }} est actif
                                        @else
                                            {{ $data->name }} est innactif
                                        @endif
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <script>
        $(".info-badge").click(function() {
            if($(this).closest(".inline-block").find(".info-tooltip").css("opacity") == 1) {
                $(this).closest(".inline-block").find(".info-tooltip").fadeTo("fast", 0);
            } else {
                $(this).closest(".inline-block").find(".info-tooltip").fadeTo("fast", 1);
            }
        });
    </script>
</x-app-layout>
