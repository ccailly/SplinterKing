@props(['title', 'desc', 'icon' => null, 'buttons' => null])

<div class="flex items-center mt-6 text-center border rounded-lg h-96 ">
    <div class="flex flex-col w-full max-w-sm px-4 mx-auto">
        @if ($icon)
            <div class="p-3 mx-auto text-blue-500 bg-blue-100 rounded-full ">
                {{ $icon }}
            </div>
        @endif
        <h1 class="mt-3 text-lg text-gray-800 ">{{ $title }}</h1>
        <p class="mt-2 text-gray-500 ">
            {!! $desc !!}
        </p>
        @if ($buttons)
            <div class="flex items-center mt-4 sm:mx-auto gap-x-3">
                {{ $buttons }}
            </div>
        @endif
    </div>
</div>
