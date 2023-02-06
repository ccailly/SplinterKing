<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-tabs active="{{ $tab }}">
                        <x-tab name="Informations">
                            @include('accounts.account.informations')
                        </x-tab>

                        <x-tab name="Roulette">
                            @include('accounts.account.wheel')
                        </x-tab>

                        <x-tab name="Coupons">
                            @include('accounts.account.coupons')
                        </x-tab>

                        <x-tab name="Snapshots">
                            @include('accounts.account.snapshots')
                        </x-tab>

                        <x-tab name="Historique">
                            @include('accounts.account.history')
                        </x-tab>
                    </x-tabs>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
