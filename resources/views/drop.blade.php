<x-app-layout>
    <div class="flex flex-col items-center justify-center w-full max-w-sm mx-auto mt-24">

        @switch($preferedReward)
            @case('CR30')
                <x-rewardsOverlays.CR30 />
            @break

            @case('CR80')
                <x-rewardsOverlays.CR80 />
            @break

            @case('CR120')
                <x-rewardsOverlays.CR120 />
            @break

            @case('CR140')
                <x-rewardsOverlays.CR140 />
            @break

            @case('CR180')
                <x-rewardsOverlays.CR180 />
            @break

            @case('CR220')
                <x-rewardsOverlays.CR220 />
            @break

            @default
                <x-rewardsOverlays.CR120 />
        @endswitch

        <div class="w-56 -mt-10 overflow-hidden bg-white rounded-lg shadow-lg md:w-64">
            <h3 class="py-2 font-bold tracking-wide text-center text-gray-800 uppercase">Récompense préférée {{ $totalPreferedReward }} Drops</h3>

            <div class="flex items-center justify-between px-3 py-2 bg-gray-200 dark:bg-gray-700">
                <span class="font-bold text-gray-800 dark:text-gray-200">{{ $preferedReward }}</span>
                <button
                    class="px-2 py-1 text-xs font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 focus:outline-none">Récuperer</button>
            </div>
        </div>
    </div>


</x-app-layout>
