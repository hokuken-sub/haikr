<div class="haik-plugin-search">
  @foreach ($data as $key => $target)
  <div class="row">
    <div class="haik-plugin-search-type col-sm-2">
     <strong class="pull-right">{{{ $target['label'] }}}</strong>
    </div>
    <div class="haik-plugin-search-results col-sm-10">
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

<style>
.haik-plugin-search .haik-plugin-search-item {
    margin: 1em 0;
}
.haik-plugin-search .haik-plugin-search-item .title a {
    color: inherit;
}
.haik-plugin-search .haik-plugin-search-item .title small {
    color: #babbbf;
}
.haik-plugin-search .haik-plugin-search-item .caption {
    color: #777;
}
</style>
