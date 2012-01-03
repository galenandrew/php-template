<?php
/**
 * ------------------------------------------------------------ *
 *	PAGE - Home
 * ------------------------------------------------------------ *
 */

//---> Define Template Data
$meta = array(
	'title' => array('Title Keyword','Title Keyword'),
	'keywords' => 'page keywords',
	'description' => 'Page description',
);
$data = array(
	# @page - Used for triggering active status in menu
	'page' => REQ_PAGE_BASE,
	# @scripts - Adds custom scripts to the header (block, inine)
	'scripts' => array(
		//'include' => '',
		//'block' => '',
	),
	# @styles - Adds custom styles to the header (block, inine)
	'styles' => array(
		//'include' => '/styles/pages/home.css',
		//'block' => '',
	),
);

include(TEMPLATE_PATH.'header.php');
// #################################### [BEGIN] PAGE HTML CONTENT #################################### \\
?>
<div class="page-header">
	<h1>Homepage</h1>
</div>
<div class="page-content">
	<h2>Headline</h2>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque lacus elit, porta et semper et, volutpat sit amet velit. Quisque sollicitudin, elit semper lobortis mollis, dolor sapien suscipit lacus, quis facilisis lectus elit at risus. Morbi lacinia semper orci, at vestibulum massa varius eget. Nulla egestas, diam in consequat lacinia, libero leo eleifend massa, eget posuere velit ipsum sit amet mauris. Duis vel arcu justo, non faucibus augue. Sed id nunc enim.</p>
</div>
<?php
// #################################### [END] PAGE HTML CONTENT #################################### \\
include(TEMPLATE_PATH.'footer.php');
?>