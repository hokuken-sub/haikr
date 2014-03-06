<div class="row">
  <div class="{{ $class }}">
    <div class="haik-plugin-search">
      {{ Form::open(array('url' => '/haik--search/', 'class' => 'form-inline', 'method' => 'get')) }}
        @if ($button)
        <div class="input-group">
          {{ Form::text('word', $word, array('class' => 'form-control', 'placeholder' => 'search')) }}
          <i class="glyphicon glyphicon-search"></i>
          <div class="input-group-btn">
            {{ Form::submit('検索', array('class' => 'btn btn-' . $button_type)) }}
          </div>
        </div>
        @else
        {{ Form::text('word', $word, array('class' => 'form-control input-search', 'placeholder' => 'Search')) }}
        <i class="glyphicon glyphicon-search"></i>
        @endif
      {{ Form::close() }}
    </div>
  </div>
</div>

<style>
.haik-plugin-search {
    position: relative;
}
.haik-plugin-search input[type=text] {
    padding-left: 2.5rem;
    width: 100%;
}
.haik-plugin-search .glyphicon-search {
    position: absolute;
    top: 10px;
    left: 7px;
    color: #babbbf;
}
</style>