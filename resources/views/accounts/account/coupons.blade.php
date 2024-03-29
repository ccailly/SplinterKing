<x-table title="Coupons" badge="{{ $coupons['total'] }} coupons disponible" :columns="$coupons['columns']" :rows="$coupons['rows']"
    :search="$coupons['search']" :pagination="$coupons['pagination']">
    <x-slot name="empty">
        <x-slot name="buttons">
            <button href="{{ route('accounts.add') }}"
                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600  ">
                <x-heroicon-o-document-magnifying-glass class="w-5 h-5" />

                <span>Demander une snapshot</span>
            </button>
        </x-slot>

        @if ($coupons['search']['value'] != '')
            <x-empty-table title="Aucun coupon trouvé"
                desc="Vous avez recherché <strong>{{ $coupons['search']['value'] }}</strong>, ce qui ne correspond a aucun coupon. Veuillez réessayer en étant plus permissif.">
                <x-slot name="icon">
                    <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                </x-slot>
                <x-slot name="buttons">
                    <a href="{{ route('accounts.show', ['account' => $account, 'tab' => 'Coupons']) }}"
                        class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto   hover:bg-gray-100  ">
                        Effacer la recherche
                    </a>
                </x-slot>
            </x-empty-table>
        @else
            <x-empty-table title="Aucun coupon trouvé" desc="Aucun coupon sur ce compte.">
                <x-slot name="icon">
                    <x-heroicon-o-ticket class="w-6 h-6" />
                </x-slot>
            </x-empty-table>
        @endif
    </x-slot>
</x-table>
