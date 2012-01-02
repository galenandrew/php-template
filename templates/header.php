<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />

<link rel="shortcut icon" href="/media/favicon.ico" />
<link rel="apple-touch-icon" href="/media/touch-icon-iphone.png" title="Square One Agency" />
<link rel="apple-touch-icon" sizes="72x72" href="/media/touch-icon-ipad.png" title="Square One Agency" />
<link rel="apple-touch-icon" sizes="114x114" href="/media/touch-icon-iphone4.png" title="Square One Agency" />

<!-- meta tags -->
<title><?php echo 'Website Template'.( !isset($meta['title']) ? '' : ' | '.(is_array($meta['title']) ? implode(', ', $meta['title']) : $meta['title']) ); ?></title>
<meta name="keywords" content="<?php echo !isset($meta['keywords']) ? '' : (is_array($meta['keywords']) ? implode(', ', $meta['keywords']) : $meta['keywords']); ?>">
<meta name="description" content="<?php echo !isset($meta['description']) ? '' : $meta['description']; ?>">

<!-- stylesheets -->
<?php
//---> Default Stylesheet
echo '<link href="/styles/'.( defined('CSS_BOOTSTRAP') && CSS_BOOTSTRAP ? 'bootstrap' : 'main' ).'.css" rel="stylesheet" type="text/css" media="all" />';

//---> Stylesheets
if(isset($data['styles']) && is_array($data['styles'])) 
{
	foreach($data['styles'] as $type => $style) {
		echo (!is_array($style)) ? ($type=='block' ? $style : '<link href="'.$style.'" rel="stylesheet" type="text/css" media="all" />'."\n") : '';

		if(is_array($style)) 
		{
			foreach($style as $style2) {
				echo ($type == 'block') ? $style2 : '<link href="'.$style2.'" rel="stylesheet" type="text/css" media="all" />'."\n";
			}
		} 
	}
} 
else if(isset($data['styles']) && !is_array($data['styles'])) 
{
	echo '<link rel="stylesheet" href="'.$data['styles'].'" type="text/css" media="all" />'."\n";
}
?>

<!-- scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
<script src="/scripts/js/main.js" type="text/javascript"></script>
<?php
//---> Scripts
if(isset($data['scripts']) && is_array($data['scripts'])) 
{
	foreach($data['scripts'] as $type => $script) {
		echo (!is_array($script)) ? ($type=='block' ? $script : '<script src="'.$script.'" type="text/javascript"></script>'."\n") : '';

		if(is_array($script)) 
		{
			foreach($script as $script2) {
				echo ($type == 'block') ? $script2 : '<script src="'.$script2.'" type="text/javascript"></script>'."\n";
			}
		} 
	}
} 
else if(isset($data['scripts']) && !is_array($data['scripts'])) 
{
	echo '<script src="'.$data['scripts'].'" type="text/javascript"></script>'."\n";
}
?>

<!--[if !IE 7]>
<link href="/styles/ie.css" rel="stylesheet" type="text/css" media="all" />
<![endif]-->
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<?php if(ob_get_length() !== FALSE) { ob_flush(); } ?>
<body>
<!-- Header -->
<header class="topbar">
	<div class="fill">
		<div class="container">
			<a class="brand" href="/">Website Title</a>
			<ul class="nav">
				<li class="active"><a href="/">Home</a></li>
				<li><a href="#menu-item">Menu Item</a></li>
				<li><a href="#menu-item">Menu Item</a></li>
				<li><a href="#menu-item">Menu Item</a></li>
			</ul>
		</div>
	</div>
</header>
<!-- End Header -->
<!-- Container -->
<div class="container">
	<!-- Content -->
	<div class="content">
