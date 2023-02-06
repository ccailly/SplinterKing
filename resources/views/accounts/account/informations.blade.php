<form action="{{ route('accounts.edit', ['account' => $account->id]) }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="mail">Mail</label>
            @if ($errors->has('mail'))
                <input disabled id="mail" name="mail" type="email"
                    value="{{ old('mail') ? old('mail') : $account->mail }}"
                    class="block mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-red-400 bg-white px-5 py-2.5 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40 dark:border-red-400 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-300" />
                <p class="mt-3 text-xs text-red-400">
                    {{ $errors->first('mail') }}
                </p>
            @else
                <input disabled id="mail" name="mail" type="email"
                    value="{{ old('mail') ? old('mail') : $account->mail }}"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            @endif
        </div>

        <div>
            <label class="text-gray-700 dark:text-gray-200" for="password">Password</label>
            @if ($errors->has('password'))
                <input required id="password" name="password" type="text"
                    value="{{ old('password') ? old('password') : $account->password }}"
                    class="block mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-red-400 bg-white px-5 py-2.5 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40 dark:border-red-400 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-300" />
                <p class="mt-3 text-xs text-red-400">
                    {{ $errors->first('password') }}
                </p>
            @else
                <input required id="password" name="password" type="text"
                    value="{{ old('password') ? old('password') : $account->password }}"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            @endif
        </div>

        <div>
            <label class="text-gray-700 dark:text-gray-200" for="qrcode">QR Code</label>
            <div class="relative flex items-center mt-2">
                <input disabled id="qrcode" name="qrcode" type="text" minlength="6" maxlength="6"
                    value="{{ old('qrcode') ? old('qrcode') : $account->qr_code }}"
                    class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40">
                <a href="{{ $account->qr_link() }}" target="_blank" class="absolute">
                    <x-heroicon-o-qr-code class="w-5 h-5 mx-3 text-gray-800" />
                </a>
            </div>
        </div>
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="birthdate">Date de
                naissance</label>
            @if ($errors->has('birthdate'))
                <input required id="birthdate" name="birthdate" type="date"
                    value="{{ old('birthdate') ? old('birthdate') : $account->birth_date }}"
                    class="block mt-2 w-full placeholder-gray-400/70 dark:placeholder-gray-500 rounded-lg border border-red-400 bg-white px-5 py-2.5 text-gray-700 focus:border-red-400 focus:outline-none focus:ring focus:ring-red-300 focus:ring-opacity-40 dark:border-red-400 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-red-300" />
                <p class="mt-3 text-xs text-red-400">
                    {{ $errors->first('birthdate') }}
                </p>
            @else
                <input id="birthdate" name=" birthdate" type="date"
                    value="{{ old('birthdate') ? old('birthdate') : $account->birth_date }}"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
            @endif
        </div>
        <div>
            <label class="text-gray-700 dark:text-gray-200" for="hasKids">Enfants
                enregistrés</label>
            <input id="hasKids" name="hasKids" type="checkbox"
                {{ old('hasKids') != null ? 'checked' : ($account->has_kids ? 'checked' : '') }} value="1"
                class="px-2.5 py-2.5 ml-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-blue-300 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring">
        </div>
    </div>

    <div class="flex justify-end gap-4 mt-6">
        <x-simple-modal open="{{ $delete }}" title="Suppression" desc="Êtes-vous sûr de vouloir supprimer le compte <strong>{{ $account->mail }}</strong> ?">
            <x-slot name="icon">
                <x-heroicon-o-trash class="w-8 h-8 text-gray-700" />
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
                <a href="{{ route('accounts.delete', $account) }}"
                    class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-red-500 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">
                    Supprimer
                </a>
            </x-slot>
        </x-simple-modal>
        <button
            class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Enregistrer</button>
    </div>
</form>
