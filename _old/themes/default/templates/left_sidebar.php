
<div id="left-sidebar">

	<!-- recent articles -->
	<div id="left-box">
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
		 $result=mysql_query("SELECT * FROM articles ORDER BY article_date DESC");
		 while($row=mysql_fetch_array($result)) {
			$catPostCount[$row['article_catid']]=$row['article_id'];
			// limit to 5 results
			if($i<=5) {
		 ?>
		  <li><a href="#"><?php print $row['article_title']; ?></a></li>
		 <?php 
			}
			
			$i++;
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
		if($row['cat_parent']) {
			$catChild[$row['cat_id']]=$row['cat_parent'].'|'.$row['cat_name'];
		}
		else {
			$catArray[$row['cat_id']]=$row['cat_name'];
		}
	 }

	?>
	<div id="left-box">
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
		 <?php
		 foreach($catArray as $cat_id=>$cat_name) {
		 ?>
		  <li>
		    <a href="#<?php print $cat_id; ?>"><?php print $cat_name; ?></a> 
			<?php if(!empty($catPostCount[$cat_id])) print('<span style="font-size:9px;">(<span style="color:red">'.count($catPostCount[$cat_id]).'</span>)'); ?>
				
			<?php if(is_array($catChild) && in_array($cat_id,$catChild)) { ?>
			<ul style="color:#999">
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
	<div id="left-box">
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
	<div id="left-box">
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