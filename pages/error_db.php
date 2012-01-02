<?php
/**
 * ------------------------------------------------------------ *
 *	PAGE - DB Error
 * ------------------------------------------------------------ *
 */

$page = 'DB Error';
$meta['title'] = $page;

include(TEMPLATE_PATH.'header.php');
// #################################### [BEGIN] PAGE HTML CONTENT #################################### \\ 
?>
<div class="page-header">
	<h1><?php echo $page; ?></h1>
</div>
<div class="page-content">
	<h2>PHP runtime environment: <?php echo ENVR; ?></h2>
	<div class="alert-message block-message error">
		<p><?php echo mysql_error(); ?></p>
	</div>
</div>
<?php // #################################### [END] PAGE HTML CONTENT #################################### \\
include(TEMPLATE_PATH.'footer.php');
?>