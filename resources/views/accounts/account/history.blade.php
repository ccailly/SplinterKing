<x-table title="Historique" badge="{{ $histories['total'] }} utilisations" :columns="$histories['columns']" :rows="$histories['rows']"
    :search="$histories['search']" :pagination="$histories['pagination']">
    <x-slot name="empty">
        <x-slot name="buttons">
            <button
                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                <x-heroicon-o-plus-circle class="w-5 h-5" />

                <span>Ajouter une utilisation</span>
            </button>
        </x-slot>
        @if ($histories['search']['value'] != '')
            <x-empty-table title="Aucune utilisation trouvée"
                desc="Vous avez recherché <strong>{{ $histories['search']['value'] }}</strong>, ce qui ne correspond a aucune utilisation. Veuillez réessayer en étant plus permissif.">
                <x-slot name="icon">
                    <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                </x-slot>
                <x-slot name="buttons">
                    <a href="{{ route('accounts.show', ['account' => $account, 'tab' => 'Roulette']) }}"
                        class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                        Effacer la recherche
                    </a>
                </x-slot>
            </x-empty-table>
        @else
            <x-empty-table title="Aucune utilisation trouvée" desc="Aucune utilisation n'existe sur ce compte.">
                <x-slot name="icon">
                    <x-heroicon-o-arrow-up-on-square-stack class="w-6 h-6" />
                </x-slot>
            </x-empty-table>
        @endif
    </x-slot>
</x-table>
