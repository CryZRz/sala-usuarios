@canUse($can)
    <a href="{{ $href }}" class="{{$style}}">
        {{ $slot }}
    </a>
@else
    <a href="#"
       class="{{$style}} cursor-not-allowed opacity-50 "
       title="No tienes permisos"
       onclick="return false;">
        {{ $slot }}
    </a>
    @endcanUse
