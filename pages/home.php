<?php
if(!defined('INDEX')) die('INDEX:error');

// cfg must be global for theme to work
global $cfg;

/* get article items */
$articleItems=getArticles();
?>

{TPL:header}
<!-- // header -->

	<!-- left side bar -->
	{TPL:left_sidebar}
	<!-- // left side bar -->
	<div class="content">
		<?php
		// list article items
		if(empty($articleItems)) print('There are currently no articles to display');
		else {
		 foreach($articleItems as $article) {
			if(!$article['article_catid']) $category='';
			else $category='in <strong><a href="#">'.$article['cat_name'].'</a></strong>';
		?>
		<div class="item">
			<h1><?php print $article['article_title']; ?></h1>
			<h3>posted <?php print $category; ?> by <a href="#"><?php print $article['user_name']; ?></a> on <?php print date('m/d/y @ h:iA',$article['article_date']); ?></h3>
			<p><?php print $article['article_body'];?></p>

			<h2>&raquo; <a href="#">leave a comment</a></h2>
			</div>
		<?php
			}
		} 
		?>

{TPL:footer}
