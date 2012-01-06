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
     	eval('?>'.$this->template);
	}
}
?>