<?php
if(!defined('TPL')) die('TPL:denied');

class Template {
	public $template;

	function load($filepath) {
		$this->template = file_get_contents($filepath);
		return $this->template;
	}

	function replace($var, $content) {
		$this->template = str_replace("{TPL:$var}", $content, $this->template);
		return $this->template;
	}

	function publish() {
     	eval("?>".$this->template."");
	}
}

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