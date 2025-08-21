<div class="font-size-control">
    @foreach($fontSizes as $size => $multiplier)
        <button class="font-size-btn {{ $size === $defaultSize ? 'active' : '' }}" 
                data-size="{{ $size }}" 
                data-multiplier="{{ $multiplier }}">
            A
        </button>
    @endforeach
</div>

<link href="{{ asset('vendor/font-size-switcher/css/font-size-control.css') }}" rel="stylesheet">
<script src="{{ asset('vendor/font-size-switcher/js/font-size-control.js') }}"></script>
