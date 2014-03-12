<div class="row">
  <div class="{{ $class }}">
    <div class="haik-plugin-search-form">
      {{ Form::open(array('url' => '/haik--search/', 'class' => 'form-inline', 'method' => 'get')) }}
        @if ($button)
        <div class="input-group has-feedback">
          {{ Form::text('word', $word, array('class' => 'form-control', 'placeholder' => 'search')) }}
          <span class="glyphicon glyphicon-search form-control-feedback"></span>
          <div class="input-group-btn">
            {{ Form::submit('検索', array('class' => 'btn btn-' . $button_type)) }}
          </div>
        </div>
        @else
        <div class="form-group has-feedback">
          {{ Form::text('word', $word, array('class' => 'form-control input-search', 'placeholder' => 'Search')) }}
          <span class="glyphicon glyphicon-search form-control-feedback"></span>
        </div>
        @endif
      {{ Form::close() }}
    </div>
  </div>
</div>
