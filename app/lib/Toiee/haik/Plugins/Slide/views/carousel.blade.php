<div id="haik_plugin_slide{{ $slideId }}" class="haik-plugin-slide carousel slide" data-ride="carousel">

    @if ($isIndicatorsSet)
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @for ($i = 0; $i < count($slideData); $i++)
        <li data-target="#haik_plugin_slide{{ $slideId }}" data-slide-to="{{ $i }}"></li>
        @endfor
    </ol>
    @endif

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach ($slideData as $i => $slide)
        <div class="item{{ $i == 0 ? " active" : ''}}">
            @if (isset($slide['image']))
            <img src="{{ e($slide['image']) }}" alt="">
            @endif
            @if ($slide['isset_caption'])
            <div class="carousel-caption">
                @if (isset($slide['title']) && $slide['title'] != '')
                {{ \Parser::parse($slide['title']) }}
                @endif
                @if (isset($slide['caption']) && $slide['caption'] != '')
                {{ \Parser::parse($slide['caption']) }}
                @endif
            </div>
            @endif
        </div>
        @endforeach
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