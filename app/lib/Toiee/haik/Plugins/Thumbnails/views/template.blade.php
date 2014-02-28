<div class="haik-plugin-thumbnails row{{ $row_class ? ' '. e($row_class) : '' }}">
  @foreach ($data as $col)
    <div class="{{ e($col['class']) }}"{{ $col['style'] ? ' style="'. e($col['style']).'"' : '' }}>
      <div class="thumbnail">
        {{ isset($col['image']) ? $col['image'] : '' }}
        <div class="caption">
          {{ $col['body'] }}
        </div>
      </div>
    </div>
  @endforeach
</div>
