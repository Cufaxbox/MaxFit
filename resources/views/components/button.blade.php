 <!--<div>
     An unexamined life is not worth living. - Socrates 
</div> -->


@props(['type' => 'button', 'color' => 'blue', 'href' => null])

@if ($href)
    <a href="{{ $href }}" class="inline-flex items-center px-4 py-2 rounded-lg shadow-md text-white font-bold bg-{{ $color }}-600 border border-{{ $color }}-800 hover:bg-{{ $color }}-700">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="inline-flex items-center px-4 py-2 rounded-lg shadow-md text-white font-bold bg-{{ $color }}-600 border border-{{ $color }}-800 hover:bg-{{ $color }}-700">
        {{ $slot }}
    </button>
@endif
