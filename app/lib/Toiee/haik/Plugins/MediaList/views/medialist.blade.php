{{ $options['wrapperOpen'] }}
{{  ( ! $items) ? '<div class="haik-plugin-medialist media">' : '' }}
@foreach ($items as $i => $item)
<div class="haik-plugin-medialist media">
    <span class="{{ $item['align'] or "pull-left" }}">
        {{ $item['image'] or $defaultImage }}
    </span>
    @if ((isset($item['heading']) && $item['heading'] !== '') or $item['body'] !== '')
    <div class="media-body">
        {{ $item['heading'] or '' }}
        {{ $item['body'] }}
    </div>
    @endif
</div>
@endforeach
{{  ( ! $items) ? '</div>' : '' }}
{{ $options['wrapperClose'] }}