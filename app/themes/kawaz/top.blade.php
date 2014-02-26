@extends('kawaz::master')
    
    @section('body')
    <div class="container" id="contents">
      <div class="row">
        <div class="col-sm-12 marketing" role="main">
            {{ $content }}
        </div>
      </div>
    </div>
    @stop
