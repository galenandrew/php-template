<?php
/**
 * ------------------------------------------------------------ *
 *	PAGE - 404 Error - Page Not Found
 * ------------------------------------------------------------ *
 */

if(!defined('IS_404')) define('IS_404', TRUE);

//---> Set 404 Headers
header("HTTP/1.0 404 Not Found");
header("Status: 404 Not Found");

$page = '404 - Page Not Found';
$meta['title'] = $page;

if(!ASYNC) include(TEMPLATE_PATH . 'header.php');
// #################################### [BEGIN] PAGE HTML CONTENT #################################### \\ 
?>
<div class="page-header">
	<h1><?php echo $page; ?></h1>
</div>
<div class="page-content">
	<div class="alert-message block-message warning">
		<p>We were not able to locate that page. Please double check the URL and try again.</p>
	</div>
</div>
<?php // #################################### [END] PAGE HTML CONTENT #################################### \\
if(!ASYNC) include(TEMPLATE_PATH . 'footer.php');
?>