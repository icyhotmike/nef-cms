<?php
@error_reporting(E_ALL);
@define(PATH,dirname(__FILE__));
@define(TPL,1);
@define(FUNC,1);
@define(HOME,1);
@session_start();
$cfg=array();
$errorMsg='';

/* cfg:mysql */
$cfg['mysql_server']='localhost';
$cfg['mysql_user']='root';
$cfg['mysql_pass']='';
$cfg['mysql_dbname']='cms';
$cfg['mysql_pconnect']=0;

/* landing page */
$cfg['landing_page']='home';

/* cfg:theme */
$cfg['theme_name']='default';
$cfg['theme_templateDir']=PATH.'./themes/'.$cfg['theme_name'].'/templates/';

/* load:mysql */
$cfg['mysql_linkid']=@mysql_connect($cfg['mysql_server'],$cfg['mysql_user'],$cfg['mysql_pass']);
if(!$cfg['mysql_linkid']) die('Failed to connect MySQL server');
if(!@mysql_select_db($cfg['mysql_dbname'])) die('Failed to connect MySQL database');

/* includes */
require_once(PATH.'./class.template.php');
require_once(PATH.'./functions.php');

/* load templates */
$template = new Template;
$template->load(PATH.'./pages/'.$cfg['landing_page'].'.php');
$templateList = loadTemplates();
foreach($templateList as $tpl) {
	$tplName = substr($tpl,0,(strlen($tpl)-4));
	$template->replace($tplName, file_get_contents($cfg['theme_templateDir'].$tpl));
}


/* doLogin aSync request */
/* print @ login-response innerHTML */
if(!empty($_REQUEST['doLogin'])) {

	if(empty($_POST['login_user_name'])) $errorMsg = 'Please enter username';
	elseif(empty($_POST['login_user_password'])) $errorMsg = 'Please enter password';

	if(!empty($errorMsg)) {
		print('fail|'.$errorMsg);
		//return $errorMsg;
		exit;
	}

	else {
		$result=mysql_query("SELECT * FROM users WHERE 
		user_name = '".addslashes($_POST['login_user_name'])."' AND
		user_password = '".md5($_POST['login_user_password'])."' LIMIT 1");
		if($row=mysql_fetch_array($result)) {
			$_SESSION['nefcms_user_name']=$row['user_name'];
			$_SESSION['nefcms_user_password']=$row['user_password'];
			$_SESSION['nefcms_user_logintime']=time();
			$_SESSION['nefcms_phpsid']=session_id();
			
		}
		
		// invalid
		if(mysql_num_rows($result)==0) {
			global $errorMsg; 
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
}


/* output page */
$template->publish();
?>