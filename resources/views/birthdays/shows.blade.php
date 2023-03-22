<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                {!! $chart->container() !!}
            </div>
            <div class="bg-white shadow-sm sm:rounded-lg mt-5">
                <div class="p-6 text-gray-900">
                    <x-table title="Anniversaires actuels"
                        badge="{{ $currentBirthdays['total'] }} anniversaires actuellement" :columns="$currentBirthdays['columns']"
                        :rows="$currentBirthdays['rows']" :pagination="$currentBirthdays['pagination']">
                        <x-slot name="empty">
                            <x-empty-table title="Aucun anniversaire"
                                desc="Aucun anniversaire actuellement sur les 7 derniers jours.">
                            </x-empty-table>
                        </x-slot>
                    </x-table>
                </div>
            </div>
        </div>

        @push('end-scripts')
            {!! $chart->script() !!}
        @endpush
</x-app-layout>
