@props(['title', 'badge' => null, 'description' => null, 'buttons' => null, 'search' => null, 'filters' => null, 'columns', 'rows', 'empty' => null, 'pagination' => null])

<section class="container px-4 mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-x-3">
                <h2 class="text-lg font-semibold text-gray-700 ">{{ $title }}</h2>

                @if ($badge)
                    <span
                        class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full  ">{{ $badge }}</span>
                @endif
            </div>

            @if ($description)
                <p class="mt-1 text-sm text-gray-500 ">{{ $description }}</p>
            @endif
        </div>

        @if ($buttons)
            <div class="flex items-center mt-4 gap-x-3">
                {{ $buttons }}
            </div>
        @endif
    </div>

    @if ($filters || $search)
        <div class="mt-6 md:flex md:items-center md:justify-between">
            @if ($filters)
                <div
                    class="inline-flex bg-white border divide-x rounded-lg  rtl:flex-row-reverse  ">
                    @foreach ($filters as $name => $filter)
                        @if ($filter['active'])
                            <a href="{{ $filter['url'] }}"
                                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 bg-gray-100 sm:text-sm  ">
                                {{ $name }}
                            </a>
                        @else
                            <a href="{{ $filter['url'] }}"
                                class="px-5 py-2 text-xs font-medium text-gray-600 transition-colors duration-200 sm:text-sm   hover:bg-gray-100">
                                {{ $name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            @if ($search)
                <div class="relative flex items-center mt-4 md:mt-0">
                    <button type=submit class="absolute" form="searchForm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 mx-3 text-gray-400 ">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>

                    <form action="{{ $search['url'] }}" method="GET" id="searchForm">
                        <input type="text" name="search" id="search" placeholder="{{ $search['placeholder'] }}"
                            autocomplete="off" value="{{ $search['value'] }}"
                            class="block w-full py-1.5 pr-5 text-gray-700 bg-white border border-gray-200 rounded-lg md:w-80 placeholder-gray-400/70 pl-11 rtl:pr-11 rtl:pl-5    focus:border-blue-400  focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                    </form>
                </div>
            @endif
        </div>
    @endif

    @if ($rows)
        <div class="flex flex-col mt-6">
            <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="border border-gray-200  md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 ">
                            <thead class="bg-gray-50 ">
                                <tr>
                                    {{-- <svg class="h-3" viewBox="0 0 10 11" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path
                                                d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path
                                                d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                        </svg> --}}
                                    @foreach ($columns as $column)
                                        <th scope="col"
                                            class="px-4 py-4 text-sm font-normal capitalize text-left rtl:text-right text-gray-500 ">
                                            {{ $column }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200  ">

                                @foreach ($rows as $row)
                                    <tr>
                                        @foreach ($row as $column => $data)
                                            @if ($column != 'actions')
                                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                    <div>
                                                        <h2
                                                            class="font-medium text-gray-800  overflow-wrap">
                                                            {{ $data }}
                                                        </h2>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                    <div x-data="{ isOpen: false }" class="relative inline-block">
                                                        <!-- Dropdown toggle button -->
                                                        <button type="button" @click="isOpen = !isOpen"
                                                            class="px-1 py-1 text-gray-500 transition-colors duration-200 rounded-lg  hover:bg-gray-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="w-6 h-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                                            </svg>
                                                        </button>

                                                        <!-- Dropdown menu -->
                                                        <div x-show="isOpen" @click.away="isOpen = false"
                                                            x-transition:enter="transition ease-out duration-100"
                                                            x-transition:enter-start="opacity-0 scale-90"
                                                            x-transition:enter-end="opacity-100 scale-100"
                                                            x-transition:leave="transition ease-in duration-100"
                                                            x-transition:leave-start="opacity-100 scale-100"
                                                            x-transition:leave-end="opacity-0 scale-90"
                                                            class="absolute right-0 z-20 w-48 py-2 mt-2 origin-top-right bg-white rounded-md shadow-xl ">

                                                            @foreach ($data as $name => $action)
                                                                <a href="{{ $action['url'] }}"
                                                                    class="block px-4 py-3 text-sm text-gray-600 capitalize transition-colors duration-300 transform  hover:bg-gray-100  ">
                                                                    {{ $name }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @elseif ($empty)
        {{ $empty }}
    @endif

    @if ($pagination)
        <div class="mt-6 sm:flex sm:items-center sm:justify-between ">
            @if (isset($pagination['total']) && isset($pagination['current']))
                <div class="text-sm text-gray-500 ">
                    Page <span class="font-medium text-gray-700 ">{{ $pagination['current'] }} sur
                        {{ $pagination['total'] }}</span>
                </div>
            @endif

            <div class="flex items-center mt-4 gap-x-4 sm:mt-0">
                @if ($pagination['previous'])
                    <a href="{{ $pagination['previous']['url'] }}"
                        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100    ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                        </svg>

                        <span>
                            {{ $pagination['previous']['name'] }}
                        </span>
                    </a>
                @endif

                @if ($pagination['next'])
                    <a href="{{ $pagination['next']['url'] }}"
                        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100    ">
                        <span>
                            {{ $pagination['next']['name'] }}
                        </span>

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    @endif
</section>
