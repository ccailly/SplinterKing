<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <x-table title="Comptes" badge="{{ $total }} comptes" :search="$search" :filters="$filters" :columns="$columns"
                        :rows="$rows" :pagination="$pagination">
                        <x-slot name="buttons">
                            <a href="{{ route('accounts.add') }}"
                                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto   hover:bg-gray-100  ">
                                <x-heroicon-o-user-circle class="w-5 h-5" />

                                <span>Tâches de création de compte</span>
                            </a>
                            <a href="{{ route('accounts.add') }}"
                                class="flex items-center justify-center w-1/2 px-5 py-2 text-sm tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto gap-x-2 hover:bg-blue-600  ">
                                <x-heroicon-o-plus-circle class="w-5 h-5" />

                                <span>Ajouter un compte</span>
                            </a>
                        </x-slot>
                        <x-slot name="empty">
                            <x-empty-table title="Aucun comptes trouvé"
                                desc="Vous avez recherché <strong>{{ $search['value'] }}</strong>, ce qui ne correspond a aucun compte. Veuillez réessayer en étant plus permissif.">
                                <x-slot name="icon">
                                    <x-heroicon-o-magnifying-glass class="w-6 h-6" />
                                </x-slot>
                                <x-slot name="buttons">
                                    <button onclick="document.getElementById('search').focus();"
                                        class="w-1/2 px-5 py-2 text-sm text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto   hover:bg-gray-100  ">
                                        Modifier la recherche
                                    </button>
                                </x-slot>
                            </x-empty-table>
                        </x-slot>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
