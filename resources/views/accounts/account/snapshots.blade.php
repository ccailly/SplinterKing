<x-table title="Snapshots en attente" badge="{{ $requestedSnapshots['total'] }} snapshots en attente" :columns="$requestedSnapshots['columns']"
    :rows="$requestedSnapshots['rows']">
    <x-slot name="empty">
        <x-slot name="buttons">
            <button href="{{ route('accounts.add') }}"
                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <x-heroicon-o-document-magnifying-glass class="w-5 h-5" />

                <span>Ajouter une snapshot en attente</span>
            </button>
        </x-slot>
        <x-empty-table title="Aucune snapshot en attente" desc="Aucune snapshot en attente sur ce compte.">
            <x-slot name="icon">
                <x-heroicon-o-document-magnifying-glass class="w-6 h-6" />
            </x-slot>
            <x-slot name="buttons">
                <button
                    class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                    Demander une snapshot
                </button>
            </x-slot>
        </x-empty-table>
    </x-slot>
</x-table>

<div class="mt-10"></div>

<x-table title="Snapshots" badge="{{ $snapshots['total'] }} snapshots" :columns="$snapshots['columns']" :rows="$snapshots['rows']"
    :search="$snapshots['search']" :pagination="$snapshots['pagination']">
    <x-slot name="empty">
        <x-slot name="buttons">
            <button href="{{ route('accounts.add') }}"
                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <x-heroicon-o-document-magnifying-glass class="w-5 h-5" />

                <span>Demander une snapshot</span>
            </button>
        </x-slot>

        @if ($snapshots['search']['value'] != '')
            <x-empty-table title="Aucune snapshot trouvée"
                desc="Vous avez recherché <strong>{{ $snapshots['search']['value'] }}</strong>, ce qui ne correspond a aucune snapshot. Veuillez réessayer en étant plus permissif.">
                <x-slot name="icon">
                    <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                </x-slot>
                <x-slot name="buttons">
                    <a href="{{ route('accounts.show', ['account' => $account, 'tab' => 'Snapshots']) }}"
                        class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                        Effacer la recherche
                    </a>
                </x-slot>
            </x-empty-table>
        @else
            <x-empty-table title="Aucune snapshot trouvée" desc="Aucun snapshot sur ce compte.">
                <x-slot name="icon">
                    <x-heroicon-o-ticket class="w-6 h-6" />
                    <x-slot name="buttons">
                        <button
                            class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                            Demander une snapshot
                        </button>
                    </x-slot>
                </x-slot>
            </x-empty-table>
        @endif
    </x-slot>
</x-table>
