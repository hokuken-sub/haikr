<div class="row">
  <div class="{{ $class }}">
    <div class="haik-plugin-search">
      <form action="/haik--search/" method="get" class="form-inline">
        @if ($button)
        <div class="input-group">
          <input type="text" name="word" value="{{{ $word or '' }}}" class="form-control" placeholder="Search" />
          <i class="glyphicon glyphicon-search"></i>
          <div class="input-group-btn">
            <input class="btn btn-{{$button_type}}" type="submit" value="検索" />
          </div>
        </div>
        @else
        <input type="text" name="word" value="{{{ $word or '' }}}" class="form-control input-search" placeholder="Search" />
        <i class="glyphicon glyphicon-search"></i>
        @endif
    
      </form>
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