{{ $options['wrapperOpen'] }}
<div id="haik_plugin_slide_{{ $id }}" class="haik-plugin-slide carousel slide" data-ride="carousel">

    @if ($options['indicatorsSet'])
    <!-- Indicators -->
    <ol class="carousel-indicators">
        @for ($i = 0; $i < count($items); $i++)
        <li data-target="#haik_plugin_slide_{{ $id }}" data-slide-to="{{ $i }}"></li>
        @endfor
    </ol>
    @endif

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        @foreach ($items as $i => $item)
        <div class="item{{ $i == 0 ? " active" : ''}}">
            {{ $item['image'] or $defaultImage }}
            @if ((isset($item['heading']) && $item['heading'] !== '') or $item['body'] !== '')
            <div class="carousel-caption">
                {{ $item['heading'] or '' }}
                {{ $item['body'] }}
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @if ($options['controlsSet'])
    <!-- Controls -->
    <a class="left carousel-control" href="#haik_plugin_slide_{{ $id }}" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#haik_plugin_slide_{{ $id }}" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
    @endif

</div>
{{ $options['wrapperClose'] }}