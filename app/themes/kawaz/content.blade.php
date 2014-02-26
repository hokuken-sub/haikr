@extends('kawaz::master')

    @section('body')
    <div class="container" id="contents">
      <div class="row">
        <div class="col-sm-9 col-sm-push-3 marketing" role="main">
          {{ $content }}
        </div>
        <aside class="col-sm-3 col-sm-pull-9">
          {{ $menu }}
        </aside>
      </div>
    </div>
    @stop
