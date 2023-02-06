@props(['open'=> false, 'title', 'desc', 'icon' => null, 'openBtn' => null, 'buttons' => null])

<div x-data="{ isOpen: @js($open) }" class="relative flex justify-center">
    @if ($openBtn)
        <div @click="isOpen = true">
            {{ $openBtn }}
        </div>
    @endif

    <div x-show="isOpen" x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave="transition duration-150 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        class="backdrop-blur-[1px] fixed inset-0 z-20 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="relative inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl rtl:text-right sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                <div>
                    @if ($icon)
                        <div class="flex items-center justify-center">
                            {{ $icon }}
                        </div>
                    @endif

                    <div class="mt-2 text-center">
                        <h3 class="text-lg font-medium leading-6 text-gray-800 capitalize"
                            id="modal-title">{!! $title !!}</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            {!! $desc !!}
                        </p>
                    </div>
                </div>
                @if ($buttons)
                    <div class="mt-5 flex flex-col sm:flex-row items-stretch sm:justify-around gap-2 ">
                        {{ $buttons }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
