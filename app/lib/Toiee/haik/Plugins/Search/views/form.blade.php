<div class="row">
  <div class="{{ $class }}">
    <div class="haik-plugin-search-form">
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
