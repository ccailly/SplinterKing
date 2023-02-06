<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Demande de snapshot -
                        {{ $account->mail }}</h2>

                    <form action="{{ route('snapshots.requests.edit', ['account' => $account]) }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="account">Compte</label>
                                <select name="account" id="account" required disabled
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                                    <option value="{{ $account->id }}" selected>{{ $account->mail }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="priority">Priorité</label>
                                <select name="priority" id="priority" required
                                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority }}">{{ $priority }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <x-simple-modal open="{{ $delete }}" title="Annulation de la demande"
                                desc="Êtes-vous sûr de vouloir supprimer la demande de snapshot du compte <strong>{{ $account->mail }}</strong> ?">
                                <x-slot name="icon">
                                    <x-heroicon-o-arrow-uturn-left class="w-8 h-8 text-gray-700" />
                                </x-slot>
                                <x-slot name="openBtn">
                                    <button type="button"
                                        class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">
                                        Supprimer
                                    </button>
                                </x-slot>
                                <x-slot name="buttons">
                                    <button type="button" @click="isOpen = false"
                                        class="px-8 py-2.5 leading-5 text-gray-700 transition-colors duration-200 bg-white border rounded-lg sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-gray-700">
                                        Annuler
                                    </button>
                                    <a href="{{ route('snapshots.requests.delete', $account) }}"
                                        class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">
                                        Supprimer
                                    </a>
                                </x-slot>
                            </x-simple-modal>
                            <button
                                class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
