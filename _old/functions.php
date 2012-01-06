<?php
@error_reporting('E_ALL');
if(!defined('FUNC')) die('no FUNC');


function loadTemplates() {
	global $cfg;

	$dir = $cfg['theme_templateDir'];

	if(is_dir($dir)) {
		if($dh = opendir($dir)) {
			$pageTemplates=array();
			while(($file = readdir($dh)) !== false) {
				$ext = substr($file,(strlen($file)-3),strlen($file));
				if($ext == 'php') {
					$pageTemplates[$file] = $file;
				}
			}

			if(empty($pageTemplates)) die('Failed to load templates for page:' .$pageName);
		}
		
		else die('Failed to open template dir: '.$dir);
	}
	
	else die('Failed to load template dir: '.$dir);
	
	return $pageTemplates;
}
?>