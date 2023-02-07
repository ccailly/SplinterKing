<x-app-layout>
    {{ $snapshots }}
    <div class="flex flex-col items-center justify-center w-full max-w-sm mx-auto mt-24 gap-28">

        <div class="flex flex-row items-center justify-center w-full max-w-sm mx-auto mt-24">

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

                <div class="w-56 -mt-10 overflow-hidden bg-white rounded-lg shadow-lg md:w-80">
                    <h3 class="py-2 font-bold tracking-wide text-center text-gray-800 uppercase">Récompense préférée
                        {{ $totalPreferedReward }} Drops</h3>

                    <div class="flex items-center justify-between px-3 py-2 bg-gray-200">
                        <span class="font-bold text-gray-800">{{ $preferedReward }}</span>
                        <button
                            class="px-2 py-1 text-xs font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-gray-700 focus:bg-gray-700 focus:outline-none">Récuperer</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white">
            <div class="container px-6 py-8 mx-auto">
                <p class="text-xl text-center text-gray-500">
                    Choisissez votre récompense
                </p>

                <h1 class="mt-4 text-2xl font-semibold text-center text-gray-800 capitalize lg:text-3xl">
                    Couronnes</h1>

                <div class="mt-6 space-y-8 xl:mt-12">
                    <div
                        class="flex items-center justify-between max-w-2xl px-8 py-4 mx-auto border cursor-pointer rounded-xl">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 sm:h-9 sm:w-9"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>

                            <div class="flex flex-col items-center mx-5 space-y-1">
                                <h2 class="text-lg font-medium text-gray-700 sm:text-2xl">Basic</h2>

                                <div class="px-2 text-xs text-blue-500 bg-gray-100 rounded-full sm:px-4 sm:py-1 ">
                                    Save 20%
                                </div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-semibold text-gray-500 sm:text-3xl">$49 <span
                                class="text-base font-medium">/Month</span></h2>
                    </div>

                    <div
                        class="flex items-center justify-between max-w-2xl px-8 py-4 mx-auto border border-blue-500 cursor-pointer rounded-xl">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600 sm:h-9 sm:w-9"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>

                            <div class="flex flex-col items-center mx-5 space-y-1">
                                <h2 class="text-lg font-medium text-gray-700 sm:text-2xl">Popular
                                </h2>
                                <div class="px-2 text-xs text-blue-500 bg-gray-100 rounded-full sm:px-4 sm:py-1 ">
                                    Save 20%
                                </div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-semibold text-blue-600 sm:text-4xl">$99 <span
                                class="text-base font-medium">/Month</span></h2>
                    </div>

                    <div
                        class="flex items-center justify-between max-w-2xl px-8 py-4 mx-auto border cursor-pointer rounded-xl">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 sm:h-9 sm:w-9"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>

                            <div class="flex flex-col items-center mx-5 space-y-1">
                                <h2 class="text-lg font-medium text-gray-700 sm:text-2xl">Enterprise
                                </h2>
                                <div class="px-2 text-xs text-blue-500 bg-gray-100 rounded-full sm:px-4 sm:py-1 ">
                                    Save 20%
                                </div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-semibold text-gray-500 sm:text-3xl">$149 <span
                                class="text-base font-medium">/Month</span></h2>
                    </div>

                    <div class="flex justify-center">
                        <button
                            class="px-8 py-2 tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                            Choose Plan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
