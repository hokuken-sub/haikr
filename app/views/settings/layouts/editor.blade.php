@extends('master')

@section('head')
<!--     #{$meta_content_type} -->

    <title><!-- #{$page_title} --></title>

<!--

    #{$viewport}
    #{$bootstrap_css}

-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo asset('assets/css/settings.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/css/admin.css'); ?>">

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
<!-- 	#{$body} -->
<!-- @yield('content') -->
{{ $content }}
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



<!--
#{$admin_nav}
#{$body_last}
-->
<script src="//code.jquery.com/jquery.js"></script>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/jquery.exnote.js') }}"></script>
<script src="{{ asset('assets/js/admin.js') }}"></script>

<!-- Script
================================================== -->
<!--
#{$jquery_script}
#{$bootstrap_script}
#{$common_script}
#{$admin_script}

#{$plugin_script}
-->
<!-- <script type="text/javascript" src="#{$style_path}skin.js"></script> -->
@stop
