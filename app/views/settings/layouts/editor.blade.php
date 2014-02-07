@extends('master')

@section('head')
<!--     #{$meta_content_type} -->

    <title>{{{ $page_title or 'haik settings' }}}</title>

<!--

    #{$viewport}
    #{$bootstrap_css}

-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css') }}

    {{ HTML::style(asset('assets/js/haik.css')) }}
    {{ HTML::style(asset('assets/css/settings.css')) }}
    {{ HTML::style(asset('assets/css/admin.css')) }}


    <meta name="author" content="">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="#{$rss_link}">
    
    
    <!-- Le styles -->
<!--     #{$style_css} -->
    
<!--
    #{$head_tag}
    #{$plugin_head}
-->
@stop

@section('body')

<!--
#{$body_first}
#{$sr_link}

-->
<!-- Body
================================================== -->
<div class="container" id="contents">
<div class="content-wrapper editor-wrapper" role="main">
  @include($view)
</div>
</div>

<aside>
<!-- #{$summary} -->
</aside>


<!-- Footer
================================================== -->
<footer class="footer">
<div id="license" class="container">
<!-- 	#{$license_tag} -->
</div>
</footer>

<div id="admin_nav" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#"><!-- <img src="'.IMAGE_DIR.'haiklogo.jpg" width="50" height="50"> --></a>
    @include($nav)
  </div>
</div>

<!--
#{$body_last}
-->

<!-- Script
================================================== -->
{{ HTML::script('//code.jquery.com/jquery.js') }}
{{ HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js') }}

{{ HTML::script(asset('assets/js/jquery.exnote.js')) }}
{{ HTML::script(asset('assets/js/haik.js')) }}
{{ HTML::script(asset('assets/js/admin.js')) }}

<!--
#{$jquery_script}
#{$bootstrap_script}
#{$common_script}
#{$admin_script}

#{$plugin_script}
-->
<!-- <script type="text/javascript" src="#{$style_path}skin.js"></script> -->


@stop
