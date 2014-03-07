<hr>

<div class="haik-plugin-search-results">

  @foreach ($data as $key => $target)
  <div class="row">
    <div class="haik-plugin-search-type col-sm-2">
     <div class="pull-right">{{{ $target['label'] }}}</div>
    </div>
    <div class="haik-plugin-search-items col-sm-10">
      @foreach ($target['rows'] as $row)
      <div class="haik-plugin-search-item row">
        <div class="col-sm-9">
          <div class="title">
            <a href="{{{ $row['url'] }}}"><strong>{{ $row['title'] }}</strong></a>
            <span class="sub_title">{{{ $row['sub_title'] or '' }}}</span>
          </div>
          <div class="caption">
            {{ $row['caption'] or '' }}
          </div>
        </div>
        <div class="col-sm-3">
          {{ $row['thumbnail'] or '' }}
          <small class="pull-right updated">{{{ $row['updated'] or '' }}}</small>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endforeach

</div>
