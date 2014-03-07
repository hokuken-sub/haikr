<hr>

<div class="haik-plugin-search-results">

  @foreach ($data as $key => $target)
  <div class="row">
    <div class="haik-plugin-search-type col-sm-2">
     <strong class="pull-right">{{{ $target['label'] }}}</strong>
    </div>
    <div class="haik-plugin-search-items col-sm-10">
      @foreach ($target['rows'] as $row)
      <div class="haik-plugin-search-item row">
        <div class="col-sm-9">
          <div class="title">
            <a href="{{{ $row['url'] }}}"><strong>{{ $row['title'] }}</strong>   <small>{{{ $row['sub_title'] or '' }}}</small></a>
          </div>
          <div class="caption">
            {{ $row['caption'] }}
          </div>
        </div>
        <div class="col-sm-3">
          {{ $row['thumbnail'] }}
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endforeach

</div>
