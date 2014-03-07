<div class="haik-plugin-search">

  @include('form')
  
  @if (isset($data))
      @include('results')
  @endif

</div>


<style>
.haik-plugin-search .haik-plugin-search-form {
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
.haik-plugin-search .haik-plugin-search-results {
    margin-top: 20px;
}
.haik-plugin-search .haik-plugin-search-item {
    margin-bottom: 1em;
}
.haik-plugin-search .haik-plugin-search-item .title a {
    color: inherit;
}
.haik-plugin-search .haik-plugin-search-item .sub_title {
    color: #aaa;
    margin-left: 10px;
}
.haik-plugin-search .haik-plugin-search-item .updated {
    color: #babbbf;
}
.haik-plugin-search .haik-plugin-search-item .caption {
    color: #777;
}
</style>
