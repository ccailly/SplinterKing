@props(['title', 'search'])

<div class="flex items-center mt-6 text-center border rounded-lg h-96 dark:border-gray-700">
    <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
        <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full dark:bg-gray-800">
            <x-heroicon-o-magnifying-glass class="w-6 h-6" />
        </div>
        <h1 class="mt-3 text-lg text-gray-800 dark:text-white">Aucun {{ strtolower($title) }} trouvé</h1>
        <p class="mt-2 text-gray-500 dark:text-gray-400">Vous avez recherché <strong>{{ $search['value'] }}</strong>, ce qui ne correspond a aucun {{ strtolower($title) }}. Veuillez réessayer en étant plus permissif.</p>
        <div class="flex items-center mt-4 sm:mx-auto gap-x-3">
            <button onclick="document.getElementById('search').focus();"
                class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                Modifier la recherche
            </button>
        </div>
    </div>
</div>
