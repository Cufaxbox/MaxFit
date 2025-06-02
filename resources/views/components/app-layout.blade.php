<div>
    @isset($header)
        {{ $header }}
    @endisset
    
    {{ $slot }}
</div>