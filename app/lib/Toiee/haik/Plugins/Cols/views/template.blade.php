<div class="haik-plugin-cols row{{ $row_class ? ' '. e($row_class) : '' }}">
@foreach ($data as $col)
    <div class="{{ e($col['class']) }}"{{ $col['style'] ? ' style="'. e($col['style']).'"' : '' }}>
      {{ $col['body'] }}
    </div>
@endforeach
</div>