<!DOCTYPE html>
<html lang="ja">

  <head>
    <title>{{{ $page_title }}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    {{ HTML::style('//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css') }}
    {{ HTML::style(asset('assets/themes/kawaz/stylesheets/docs.css')) }}

    <meta name="author" content="">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<!-- #{$rss_link} -->">
    <meta name="keywords" content="<!-- #{$keywords} -->">
    <meta name="description" content="<!-- #{$description} -->">

<!--

  #{$viewport}
  #{$bootstrap_css}
  #{$meta_content_type}

	#{$head_tag}
	#{$plugin_head}
	#{$user_head}
	
	#{$tracking_script}

-->
  </head>

  <body>
<!--
#{$body_first}
#{$sr_link}
-->

    <header>
      <!-- Navbar
      ================================================== -->
      <div id="orgm_navbar" class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header navbar-right">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <div id="logo"><!-- #{$logo} --></div>
          </div>
          <nav class="navbar-collapse collapse">
<!--           @yield('site_nav') -->
          <!-- 				#{$site_navigator} -->
          </nav>
        </div>
      </div>
      
      <!-- EyeCatch
      ================================================== -->
      <div id="orgm_eyecatch">
        @yield('eyecatch')
      <!-- 		#{$eyecatch} -->
      </div>
    </header>

    <!-- Body
    ================================================== -->
    @yield('body')
    
    <aside>
      <!-- 	#{$summary} -->
    </aside>

    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <div class="row">
<!--           @yield('site_footer') -->
        <!-- 			#{$site_footer} -->
        </div>
      </div>
      <div id="license" class="container">
<!--           @yield('license_tag') -->
        <!-- 		#{$license_tag} -->
      </div>
    </footer>

    <!--
    #{$admin_nav}
    #{$body_last}
    -->
    
    
    <!-- Script
    ================================================== -->
    <!--
    #{$jquery_script}
    #{$bootstrap_script}
    #{$common_script}
    #{$admin_script}
    
    #{$plugin_script}
    #{$user_script}
    -->
    {{ HTML::script('//code.jquery.com/jquery.js') }}
    {{ HTML::script('//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js') }}
    {{ HTML::script(asset('assets/javascript/haik.js')) }}

  </body>

</html>