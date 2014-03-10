{{ $options['wrapperOpen'] }}
<div class="haik-plugin-medialist media">
    @foreach ($items as $i => $item)
    <span class="{{ $item['align'] or "pull-left" }}">
        {{ $item['image'] or $defaultImage }}
    </span>
    @if ((isset($item['heading']) && $item['heading'] !== '') or $item['body'] !== '')
    <div class="media-body">
        {{ $item['heading'] or '' }}
        {{ $item['body'] }}
    </div>
    @endif
    @endforeach
</div>
{{ $options['wrapperClose'] }}