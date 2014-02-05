<!DOCTYPE html>
<html lang="ja">
<head prefix="#{$head_prefix}">
	<meta charset="UTF-8">
	<title>#{$page_title}</title>
	#{$viewport}
	<meta name="keywords" content="#{$keywords}">
	<meta name="description" content="#{$description}">
	<meta name="author" content="">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="#{$rss_link}">

	#{$bootstrap_css}
	#{$style_css}
	
	#{$head_tag}
	#{$plugin_head}
	#{$user_head}
	
	#{$tracking_script}

</head>

<body>
#{$body_first}
#{$sr_link}

<div id="orgm_container" class="container">
	
	<header>
		<!-- Navbar
		================================================== -->
		<div class="musthead">
			<h1 id="logo">#{$logo}</h1>
			<div id="orgm_navbar" class="navbar navbar-default">
				<div class="container">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<nav class="navbar-collapse collapse">
						#{$site_navigator}
					</nav>
				</div>
			</div>
		</div>
	
		<!-- EyeCatch
		================================================== -->
		<div id="orgm_eyecatch">#{$eyecatch}</div>
		
	</header>

	<!-- Body
	================================================== -->
	<div id="contents">
		<div class="row">
			<div class="col-sm-12 marketing" role="main">
				#{$body}
			</div>
		</div>
	</div>

	<aside>
		#{$summary}
	</aside>

	<hr>

	<!-- Footer
	================================================== -->
	<footer class="footer">
		#{$site_footer}
	</footer>

</div>

<div id="license">
	#{$license_tag}
</div>

#{$admin_nav}
#{$body_last}

<!-- Script
================================================== -->
#{$jquery_script}
#{$bootstrap_script}
#{$common_script}
#{$admin_script}

#{$plugin_script}
#{$user_script}

</body>
</html>