<?php
$config = array(
	'name' => 'kawaz',
	'version' => '1.1.1',
	'thumbnail' => 'img/thumbnail.png',
	'style_file' => 'css/docs.css',
	'templates' => array(
		'top' => array(
			'filename' => 'top.skin.php',
			'layouts' => array('SiteNavigator', 'SiteFooter'),
			'thumbnail' => 'img/thumbnail.top.png',
		),
		'content' => array(
			'filename' => 'content.skin.php',
			'layouts' => array('SiteNavigator', 'SiteFooter', 'MenuBar'),
			'thumbnail' => 'img/thumbnail.content.png',
		),
	),
	'default_template' => 'content',
	'colors' => array(
		'black'        => 'css/color.black.css',
		'gray'         => 'css/color.gray.css',
		'hemp'         => 'css/color.hemp.css',
		'navy'         => 'css/color.navy.css',
		'sakura'       => 'css/color.sakura.css',
		'beige'        => 'css/color.beige.css',
	),
	'textures' => array(
		'hemp-light'   => 'css/texture.hemp-light.css',
		'hemp-dark'    => 'css/texture.hemp-dark.css',
		'square'       => 'css/texture.square.css',
		'wood'         => 'css/texture.wood.css',
		'rainbow'      => 'css/texture.rainbow.css',
	),
	'sample_style_file' => 'css/samples.css',
);
