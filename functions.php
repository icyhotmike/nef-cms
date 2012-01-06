<?php
if(!defined('FUNC')) die('FUNC:denied');

function doLogin($userName,$userPass) {
	global $cfg, $template;
	
	if(empty($userName)) $errorMsg = 'Please enter username';
	elseif(empty($userPass)) $errorMsg = 'Please enter password';
	
	if(!empty($errorMsg)) {
		print('fail|'.$errorMsg);
		exit;
	}

	else {
		$result=@mysql_query("SELECT * FROM users WHERE 
		user_name = '".addslashes($userName)."' AND
		user_password = '".md5($userPass)."' LIMIT 1");
		if($row=@mysql_fetch_assoc($result)) {
			$_SESSION['nefcms_user_name']=$row['user_name'];
			$_SESSION['nefcms_user_password']=$row['user_password'];
			$_SESSION['nefcms_user_logintime']=time();
			$_SESSION['nefcms_phpsid']=session_id();
			
		}
		
		// invalid
		if(@mysql_num_rows($result)==0) {
			$errorMsg = 'Invalid user name or password';
			print('fail|'.$errorMsg);
			exit;
		}
		
		// return true
		else {
			$nefcms_userName=$_POST['login_user_name'];
			$nefcms_userLoginTime=time();
			eval('?>true|'.$template->load($cfg['theme_templateDir'].'left_sidebar_loggedin.php'));
			exit;
		}
	}
	
	@mysql_free_result($result);
}

/* get categories 
function getCats() {
	$catChild=array();
	$catParent=array();
	$catsArray=array();
	$catNames=array();
	$result=@mysql_query("SELECT * FROM cats");
	while($row=@mysql_fetch_assoc($result)) {
		$catNames[$row['cat_id']]=$row['cat_name'];
		if($row['cat_parent']>0) array_push($catChild,$row);
		else array_push($catParent,$row);
	}
	
	
	$catArray=array();
	if(!empty($catParent)) {
		foreach($catParent as $cat) {
		
			$c=0;
			foreach($catChild as $child) {
				if($cat['cat_id']==$child['cat_parent']) {
					$childName=$catNames[$child['cat_id']];
					if(!$c) $catChildList='|child:|'.$child['cat_name'];
					else $catChildList .= ','.$child['cat_name'];
					$c++;
				}
			}
			
			
			if(empty($catChilds[$cat['cat_id']])) $catArray[$cat['cat_id']]=$cat;
			else $catArray[$cat['cat_id']]=$cat.$catChildList;
		}
	}
	
	die(var_dump($catArray));

	return $catArray;
} */

/* get article items */
/* returns all fetched results into an array */
function getArticles($orderBy='',$orderDir='DESC',$max=0) {

	$articlesArray=array();
	// defaults
	$order='ORDER BY articles.article_date DESC';
	$limit='';
	
	if(empty($orderDir)) $orderDir='DESC';
	if(!empty($orderBy)) $order=' ORDER BY articles.'.$orderBy.' '.$orderDir;
	if(!empty($max)) $limit=' LIMIT '.$max;

	$result=@mysql_query("SELECT articles.*,users.user_name,cats.cat_name FROM articles 
	LEFT JOIN users ON users.user_id = articles.article_user_id 
	LEFT JOIN cats on cats.cat_id = articles.article_catid ".$order.$limit);
	if(empty($result)) die(mysql_error());
	while($row=@mysql_fetch_assoc($result)) {
		array_push($articlesArray,$row);
	}
	
	@mysql_free_result($result);
	
	return $articlesArray;
}
?>