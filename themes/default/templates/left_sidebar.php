
<div class="left-sidebar">

	<!-- recent articles -->
	<div class="left-box">
		<div class="ribbon-wrapper">
			<div class="ribbon-front">
				<h2>Recent Articles</h2>
			</div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-back-left"></div>
		</div>
		<div class="ribbon-box">
		 <ul>
		 <?php
		 $i=0;
		 $catPostCount=array();
		 if(!empty($articleItems)) {
		  foreach($articleItems as $article) {
		    // count the number of posts for each category
			$catPostCount[$article['article_catid']]=$article['article_id'];
			// only show 5 most recent articles
			if($i<=5) {
		 ?>
		  <li><a href="#"><?php print $article['article_title']; ?></a></li>
		 <?php 
				}
				
				$i++;
			}
		 } 
		 ?>
		 </ul>
		</div>
	</div>
	<!-- // recent articles -->
	
	
	
	<!-- load categories -->
	<?php
	 $catArray=array();
	 $catChild=array();
	 $result=mysql_query("SELECT * FROM cats");
	 while($row=mysql_fetch_array($result)) {
		if($row['cat_parent']) $catChild[$row['cat_id']]=$row['cat_parent'].'|'.$row['cat_name'];
		else $catArray[$row['cat_id']]=$row['cat_name'];
	 }

	?>
	<div class="left-box">
		<!-- categories -->
		<div class="ribbon-wrapper">
			<div class="ribbon-front">
				<h2>Categories</h2>
			</div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-back-left"></div>
		</div>
		<div class="ribbon-box">
		 <ul>
		 <!-- parent categories -->
		 <?php
		 foreach($catArray as $cat_id=>$cat_name) {
		 ?>
		  <li>
		    <a href="#<?php print $cat_id; ?>"><?php print $cat_name; ?></a> 
			<?php if(!empty($catPostCount[$cat_id])) print('<span style="font-size:9px;">(<span style="color:red">'.count($catPostCount[$cat_id]).'</span>)'); ?>
			<!-- child categories -->
			<?php if(is_array($catChild) && in_array($cat_id,$catChild)) { ?>
			<ul>
			 <?php 
			 foreach($catChild as $chCat_id=>$chCat_str) {
				$chArray=explode('|',$chCat_str);
				$chCat_name=$chArray[1];
				if($chArray[0]==$cat_id) {
			?>
				<li>
				<a href="#<?php print $chCat_id; ?>"><?php print $chCat_name; ?></a> 
				<?php if(!empty($catPostCount[$chCat_id])) print('<span style="font-size:9px;">(<span style="color:red">'.count($catPostCount[$chCat_id]).'</span>)</span>'); ?>
			</li>
			 <?php 
				}
			}
			?>
			</ul>
			<?php } ?>
		  </li>
		  <?php } ?>
		 </ul>
		 
		</div>
	</div>
	<!-- // categories -->
	
	
	
	<!-- login or logged-in -->
	<div class="left-box">
	<?php
	if(empty($_SESSION['nefcms_user_name']) or empty($_SESSION['nefcms_user_password'])) {
		// no session
	?>
		{TPL:left_sidebar_login}
	<?php
	} else { 
		// session found
	?>
		{TPL:left_sidebar_loggedin}
	<?php } ?>
	
	</div>
	<!-- // login or logged-in -->
	
	
	
	<!-- custom box -->
	<div class="left-box">
		<div class="ribbon-wrapper">
			<div class="ribbon-front">
				<h2>Custom Box</h2>
			</div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-back-left"></div>
		</div>
		<div class="ribbon-box">
		 <p>
		 Display any type of content here such as RSS feeds or Facebook activity
		 </p>
		</div>
	</div>
	<!-- // custom box -->
	
	
</div>