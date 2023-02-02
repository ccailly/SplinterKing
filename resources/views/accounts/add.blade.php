<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold text-gray-700 dark:text-white">Ajouter un compte</h2>

                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="mail">Mail</label>
                                @if ($errors->has('mail'))
                                    <input required id="mail" name="mail" type="email"
                                        value="{{ old('mail') }}"
                                        class="block mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-red-400 bg-white px-5 py-2.5 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40 dark:border-red-400 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-300" />
                                    <p class="mt-3 text-xs text-red-400">
                                        {{ $errors->first('mail') }}
                                    </p>
                                @else
                                    <input required id="mail" name="mail" type="email"
                                        value="{{ old('mail') }}"
                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                                @endif
                            </div>

                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="password">Password</label>
                                @if ($errors->has('password'))
                                    <input required id="password" name="password" type="text"
                                        value="{{ old('password') }}"
                                        class="block mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-red-400 bg-white px-5 py-2.5 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40 dark:border-red-400 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-300" />
                                    <p class="mt-3 text-xs text-red-400">
                                        {{ $errors->first('password') }}
                                    </p>
                                @else
                                    <input required id="password" name="password" type="text"
                                        value="{{ old('password') }}"
                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                                @endif
                            </div>
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="qrcode">QR Code</label>
                                @if ($errors->has('qrcode'))
                                    <input required id="qrcode" name="qrcode" type="text" minlength="6"
                                        maxlength="6" value="{{ old('qrcode') }}"
                                        class="block mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-red-400 bg-white px-5 py-2.5 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40 dark:border-red-400 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-300" />
                                    <p class="mt-3 text-xs text-red-400">
                                        {{ $errors->first('qrcode') }}
                                    </p>
                                @else
                                    <input required id="qrcode" name="qrcode" type="text" minlength="6"
                                        maxlength="6" value="{{ old('qrcode') }}"
                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                                @endif
                            </div>
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="birthdate">Date de
                                    naissance</label>
                                @if ($errors->has('birthdate'))
                                    <input required id="birthdate" name="birthdate" type="date"
                                        value="{{ old('birthdate') }}"
                                        class="block mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-red-400 bg-white px-5 py-2.5 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40 dark:border-red-400 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-300" />
                                    <p class="mt-3 text-xs text-red-400">
                                        {{ $errors->first('birthdate') }}
                                    </p>
                                @else
                                    <input id="birthdate" type="date" value="{{ old('birthdate') }}"
                                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                                @endif
                            </div>
                            <div>
                                <label class="text-gray-700 dark:text-gray-200" for="hasKids">Enfants
                                    enregistrés</label>
                                <input id="hasKids" name="hasKids" type="checkbox" value="{{ old('hasKids') }}"
                                    class="px-2.5 py-2.5 ml-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button
                                class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
