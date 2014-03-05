<div id="haik_plugin_slide{{ $slideId }}" class="haik-plugin-slide carousel slide" data-ride="carousel">

    @if ($isIndicatorsSet)
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @for ($i = 0; $i < $slides; $i++)
        <li data-target="#haik_plugin_slide{{ $slideId }}" data-slide-to="{{ $i }}"></li>
        @endfor
    </ol>
    @endif

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @for ($i = 0; $i < $slides; $i++)
        <div class="item {{ $i == 0 ? "active" : ''}}">
            @if (isset($imageSources[$i]))
            <img src="{{ e($imageSources[$i]) }}" alt="">
            @endif
            @if ($isCaptionsSet[$i])
            <div class="carousel-caption">
                @if (isset($titles[$i]) && $titles[$i] != '')
                {{ \Parser::parse($titles[$i]) }}
                @endif
                @if (isset($captions[$i]) && $captions[$i] != '')
                {{ \Parser::parse($captions[$i]) }}
                @endif
            </div>
            @endif
        </div>
        @endfor
    </div>

    @if ($isControlsSet)
    <!-- Controls -->
    <a class="left carousel-control" href="#haik_plugin_slide{{ $slideId }}" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#haik_plugin_slide{{ $slideId }}" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
    @endif

</div>