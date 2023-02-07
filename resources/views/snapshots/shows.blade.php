<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-table title="Snapshots en attente" badge="{{ $requestedSnapshots['total'] }} snapshots en attente"
                        :columns="$requestedSnapshots['columns']" :rows="$requestedSnapshots['rows']" :pagination="$requestedSnapshots['pagination']">
                        <x-slot name="empty">
                            <x-slot name="buttons">
                                <a href="{{ route('snapshots.requests.add') }}"
                                    class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                                    <x-heroicon-o-document-magnifying-glass class="w-5 h-5" />

                                    <span>Ajouter une snapshot en attente</span>
                                </a>
                            </x-slot>
                            <x-empty-table title="Aucune snapshot en attente"
                                desc="Aucune snapshot en attente sur ce compte.">
                                <x-slot name="icon">
                                    <x-heroicon-o-document-magnifying-glass class="w-6 h-6" />
                                </x-slot>
                                <x-slot name="buttons">
                                    <a href="snapshots.requests.add"
                                        class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                        Demander une snapshot
                                    </a>
                                </x-slot>
                            </x-empty-table>
                        </x-slot>
                    </x-table>
                </div>
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg mt-5">
                <div class="p-6 text-gray-900">
                    <x-table title="Snapshots" badge="{{ $snapshots['total'] }} snapshots" :search="$snapshots['search']"
                        :filters="$snapshots['filters']" :columns="$snapshots['columns']" :rows="$snapshots['rows']" :pagination="$snapshots['pagination']">
                        <x-slot name="buttons">
                            <a href="{{ route('accounts.add') }}"
                                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                <x-heroicon-o-user-circle class="w-5 h-5" />

                                <span>Tâches de vérifications</span>
                            </a>
                        </x-slot>
                        <x-slot name="empty">
                            @if ($snapshots['search']['value'])
                                <x-empty-table title="Aucune snapshot trouvée"
                                    desc="Vous avez recherché <strong>{{ $snapshots['search']['value'] }}</strong>, ce qui ne correspond a aucune snapshot. Veuillez réessayer en étant plus permissif.">
                                    <x-slot name="icon">
                                        <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                                    </x-slot>
                                    <x-slot name="buttons">
                                        <button onclick="document.getElementById('search').focus();"
                                            class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                            Modifier la recherche
                                        </button>
                                    </x-slot>
                                </x-empty-table>
                            @else
                                <x-empty-table title="Aucune snapshot" desc="Aucune snapshot sur ce compte.">
                                    <x-slot name="icon">
                                        <x-heroicon-o-document-magnifying-glass class="w-6 h-6" />
                                    </x-slot>
                                    <x-slot name="buttons">
                                        <a href="{{ route('snapshots.requests.add') }}"
                                            class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                            Demander une snapshot
                                        </a>
                                    </x-slot>
                                </x-empty-table>
                            @endif
                        </x-slot>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
