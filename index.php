<?php
@error_reporting(E_ALL);
@define(PATH,dirname(__FILE__));
@define(INDEX,1);
@define(TPL,1);
@define(FUNC,1);
@session_start();
$cfg=array();
$errorMsg='';

/* measure load */
$microTime = microtime();
$microTime = explode(' ', $microTime);
$microTime = $microTime[1] + $microTime[0];
$loadStart = $microTime;

/* cfg:mysql */
$cfg['mysql_server']='localhost';
$cfg['mysql_user']='root';
$cfg['mysql_pass']='';
$cfg['mysql_dbname']='cms';
$cfg['mysql_pconnect']=0;
$cfg['mysql_linkid']=0;

/* landing page */
$cfg['landing_page']='home';

/* cfg:theme */
$cfg['theme_name']='default';
$cfg['theme_templateDir']='./themes/'.$cfg['theme_name'].'/templates/';

/* load:mysql */
$cfg['mysql_linkid']=@mysql_connect($cfg['mysql_server'],$cfg['mysql_user'],$cfg['mysql_pass']);
if(!$cfg['mysql_linkid']) die('Failed to connect to MySQL.');
if(!@mysql_select_db($cfg['mysql_dbname'])) die('Failed to connect MySQL database');

/* includes */
require_once(PATH.'./class.template.php');
require_once(PATH.'./functions.php');

/* load template class */
$template = new Template;



/* doLogin aSync request */
/* print @ login-response innerHTML */
if(!empty($_REQUEST['doLogin'])) {
	doLogin($_POST['login_user_name'],$_POST['login_user_password']);
	exit;
}

/* get pages */
$pagesArray=array();
if(is_dir(PATH.'./pages/')) {
	if($dh = opendir(PATH.'./pages/')) {
		while(($file = readdir($dh)) !== false) {
			$ext = substr($file,(strlen($file)-3),strlen($file));
			$name = substr($file,0,(strlen($file)-4));
			if($ext == 'php') $pagesArray[$name]=$name;
		}
	}
}

/* validate page request */
// empty defaults to landing page set in config
if(empty($_REQUEST['page'])) $loadPage=$cfg['landing_page'];
// get requested page
elseif(in_array($_REQUEST['page'],$pagesArray)) $loadPage=$_REQUEST['page'];
// valid request but invalid page
else die('page: '.$_REQUEST['page'].', does not exist');
// else $loadPage='404error';


/* output page */
$template->load(PATH.'./pages/'.$loadPage.'.php');
$templateList = loadTemplates();
foreach($templateList as $tpl) {
	$tplName = substr($tpl,0,(strlen($tpl)-4));
	$template->replace($tplName, file_get_contents(PATH.$cfg['theme_templateDir'].$tpl));
}

$template->publish();


/* debug stats */
@print('<p>'.mysql_stat($cfg['mysql_linkid']).'</p>');

$microTime = microtime();
$microTime = explode(' ', $microTime);
$microTime = $microTime[1] + $microTime[0];
$loadEnd = $microTime;
$loadTime = round(($loadEnd - $loadStart), 4);
echo '<p>Page generated in '.$loadTime.' seconds.'.'</p>';
exit;
?>