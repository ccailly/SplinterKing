<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-700 ">Token d'accès API</h2>
                            <span class="text-sm text-gray-500">Token strictement confidentiel, ne le partagez pas avec
                                qui
                                que
                                ce soit.</span>
                        </div>

                        <a href="{{ route('profile.token.generate') }}"
                            class="ml-auto px-4 py-2 text-sm font-semibold text-white transition-colors duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                            @if ($token)
                                Regénérer
                            @else
                                Générer
                            @endif
                        </a>
                    </div>

                    <div class="pt-4 flex flex-col gap-3">
                        @if (isset($plainTokenText) || isset($token))
                            <div class="flex gap-2">
                                <input @if (isset($plainTokenText)) type="text" @else type="password" @endif
                                    class="w-full p-2 border border-gray-300 rounded-md"
                                    value="@if (isset($plainTokenText)){{ $plainTokenText }}@else{{ $token->token }} @endif"
                                    readonly>
                                @if (isset($plainTokenText))
                                    <button onclick="navigator.clipboard.writeText('{{ $plainTokenText }}')"
                                        class="px-4 py-2 text-sm font-semibold text-white transition-colors duration-300 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                        Copier
                                    </button>
                                @endif
                            </div>
                        @endif

                        <span class="text-sm text-gray-500">Un fois généré, le token ne sera plus ré-affiché.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
