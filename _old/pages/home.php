<?php
if(!defined('HOME')) die('HOME:error');
global $cfg;
?>
{TPL:header}
<!-- // header -->

<!-- left side bar -->
{TPL:left_sidebar}
<!-- // left side bar -->

<!-- container -->
<div id="container">
	<?php
	// list article items
	$result=mysql_query("SELECT articles.*,users.user_name,cats.cat_name FROM articles  
	LEFT JOIN users ON users.user_id = articles.article_user_id 
	LEFT JOIN cats ON cats.cat_id = articles.article_catid ORDER BY articles.article_date DESC");
	if(!$result) die(mysql_error());
	while($article=mysql_fetch_array($result)) {
		if(!$article['article_catid']) $category='';
		else $category='in <strong><a href="#">'.$article['cat_name'].'</a></strong>';
	?>
		<div id="item">
			
			<h1><?php print $article['article_title']; ?></h1>
			<h3>posted <?php print $category; ?> by <a href="#"><?php print $article['user_name']; ?></a> on <?php print date('m/d/y @ h:iA',$article['article_date']); ?></h3>
			<p><?php print $article['article_body'];?></p>
			
			<h2>&raquo; <a href="#">leave a comment</a></h2>
			
		</div>
	<?php } ?>
</div>
<!-- // container -->


{TPL:footer}