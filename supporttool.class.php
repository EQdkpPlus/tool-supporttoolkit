<?php
/*	Project:	EQdkp-Plus
 *	Package:	EQdkp-plus Supportool
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2016 EQdkp-Plus Developer Team
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU Affero General Public License as published
 *	by the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU Affero General Public License for more details.
 *
 *	You should have received a copy of the GNU Affero General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if(!defined('EQDKP_INC')) {
	header('HTTP/1.0 404 Not Found');exit;
}

class supporttool extends gen_class {	
	
	private $version = '0.1.3';

	private $current_step	= 'start';
	private $previous		= 'start';
	private $steps			= array();
	private $tasks		= array();
	private $current_task = '';
	private $globals		= array();
	private $included		= array();
	private $initialised	= array();
	private $order			= array();
	private $done			= array();
	private $retry_step		= false;

	public  $data			= array();

	public function init() {
		// start the installation
		$this->pdl->register_type("install_error", null, array($this, 'install_error'), array(DEBUG));
		$this->pdl->register_type("install_warning", null, array($this, 'install_warning'), array(DEBUG));
		$this->pdl->register_type("install_success", null, array($this, 'install_success'), array(DEBUG));
		$this->pdl->register_type("install_text", null, array($this, 'install_text'), array(DEBUG));
		
		$this->current_task = $this->in->get('current_task', '');
		$this->current_step = $this->in->get('current_step', 'start');
		$this->data = ($this->in->exists('step_data')) ? unserialize(base64_decode($this->in->get('step_data'))) : array();

		if($this->in->exists('next') && $this->current_step == 'end') $this->parse_end();
		if($this->in->exists('install_done')) {
			$this->done = (strpos($this->in->get('install_done'), ',') !== false) ? explode(',', $this->in->get('install_done')) : (($this->in->get('install_done') != '') ? array($this->in->get('install_done')) : array());
		}
		
		if($this->current_step == 'start'){
			$this->data = array();
			$this->done = array();
		}
		
		$this->init_language();
		$this->scan_tasks();
		$this->scan_steps();

		if(!(in_array($this->current_step, array_keys($this->steps)) || $this->current_step == 'start') && $this->current_step != 'end') $this->pdl->log('install_error', 'invalid current step');
		if($this->in->exists('select')) {
			$this->current_step = $this->in->get('select');
		} elseif($this->current_task == "" && ($this->current_step == "start" || $this->current_step == "applicationstart")){
			$this->current_step = "applicationstart";
		} elseif($this->in->exists('next') || $this->in->exists('prev') || $this->current_step == 'start' || $this->in->exists('skip')) {
			if($this->current_step == 'start' || $this->in->exists('skip') || ($this->current_step != 'end' && $this->parse_step() && $this->in->exists('next'))) $this->next_step();
			if($this->in->exists('prev') && !$this->retry_step) $this->current_step = $this->in->get('prev');
		}
		$this->show();
	}
	
	private function init_language() {
		$language = $this->in->get('inst_lang', 'english');
		if( !include_once($this->root_path .'supporttool/language/'.$language.'.php') ){
			die('Could not include the language files! Check to make sure that "' . $this->root_path . 'supporttool/language/'.$language.'.php" exists!');
		}
		
		//Load action language
		if ($this->current_task != ""){
			$lang = array_merge($lang, $this->init_action_language($this->current_task));
		}
		
		registry::add_const('lang', $lang);
	}
	
	private function init_action_language($action){
		$language = $this->in->get('inst_lang', 'english');
		if( !include($this->root_path .'supporttool/tasks/'.$action.'/language/'.$language.'.php') ){
			include($this->root_path .'supporttool/tasks/'.$action.'/language/english.php');
		}
		return $lang;
	}
	
	private function scan_tasks(){
		$path = $this->root_path.'supporttool/tasks';
		$steps = scandir($path);

		foreach($steps as $file) {
			if (is_dir($path.'/'.$file) && $file != "." && $file != ".."){
				$lang = $this->init_action_language($file);
				$this->tasks[$file] = $lang[$file];
			}
		}
	}
	
	private function scan_steps() {
		$path = $this->root_path.'supporttool/tasks/'.$this->current_task.'/';
		$steps = scandir($path);

		foreach($steps as $file) {
			if(substr($file, -10) != '.class.php') continue;
			$step = substr($file, 0, -10);
			include_once($path.$file);
			if(!class_exists($step)) $this->pdl->log('install_error', 'invalid step-file');
			if(empty($this->data[$step])) $this->data[$step] = array();
			$this->steps[] = $step;
			$this->order[call_user_func(array($step, 'before'))] = $step;
			$ajax = call_user_func(array($step, 'ajax'));
			if($ajax && $this->in->exists($ajax)) {
				$_step = registry::register($step);
				if(method_exists($_step, 'ajax_out')) $_step->ajax_out();
			}
		}
		uksort($this->order, array($this, 'sort_steps'));
	}
	
	private function sort_steps($a, $b) {
		if($a == 'start') return -1;
		if($b == 'start') return 1;
		while($c = $this->order[$b]) {
			if($c == $a) return 1;
			if(!isset($this->order[$c])) return -1;
			$b = $c;
		}
		return 0;
	}
	
	private function parse_step() {
		//remove all steps following this from the done array
		$step = end($this->order);
		while($step != $this->current_step) {
			if(in_array($step, $this->done, true)) {
				$_step = registry::register($step);
				if(method_exists($_step, 'undo')) $_step->undo();
				unset($this->done[array_search($step, $this->done)]);
			}
			$step = array_search($step, $this->order);
			if(!in_array($step, $this->steps)) {
				$this->pdl->log('install_error', $this->lang['step_order_error']);
				return false;
			}
		}
		$_step = registry::register($this->current_step);
		$back = $_step->parse_input();
		$this->data[$this->current_step] = $_step->data;
		if($back && !in_array($this->current_step, $this->done)) $this->done[] = $this->current_step;
		if(!$back && in_array($this->current_step, $this->done)) unset($this->done[array_search($this->current_step, $this->done)]);
		if(!$back) $this->retry_step = true;
		return $back;
	}
	
	private function next_step() {
		$old_current = $this->current_step;
		foreach($this->steps as $step) {
			if(call_user_func(array($step, 'before')) == $this->current_step) {
				$this->current_step = $step;
				break;
			}
		}
		if($old_current == $this->current_step) $this->current_step = 'end';
	}
	
	private function next_button() {
		if($this->current_step == 'end') return $this->lang['inst_finish'];
		if($this->current_step == 'applicationstart') return '';
		if($this->retry_step) return $this->lang['retry'];
		return $this->lang[registry::register($this->current_step)->next_button];
	}
	
	private function end() {
		$pfh = registry::register('file_handler', array('installer'));
		//delete temporary pfh folder
		$pfh->Delete($this->root_path.'data/'.md5('installer'));
		
		//Secure tmp-Folder for logs and ftp
		$pfh = registry::register('file_handler');
		$pfh->secure_folder('', 'tmp');
		
		//Set chmod644 for config.php
		@chmod($this->root_path."config.php", 0644);
		
		return $this->lang['install_end_text'];
	}
	
	private function start(){
		return $this->lang['start_text'];
	}
	
	private function parse_end() {
		header('Location: '.$this->root_path.'supporttool/index.php');

		exit;
	}
	
	private function get_content() {
		$this->previous = array_search($this->current_step, $this->order);
		if($this->current_step == 'end') return $this->end();
		if($this->current_step == 'applicationstart') return $this->start();
		
		$_step = registry::register($this->current_step);
		if(in_array($this->current_step, $this->done)) $content = $_step->get_filled_output();
		else $content = $_step->get_output();
		$this->data[$this->current_step] = $_step->data;
		return $content;
	}
	
	private function gen_menu() {
		$menu = '<h2>'.$this->lang['tasks'].'</h2>';
		foreach($this->tasks as $action => $name){
			$class = ($this->current_task == $action) ? 'now' : 'notactive';
			$menu .= '<li class="action '.$class.'" id="'.$action.'"><span><a>'.$name.'</a></span></li>';
			
			if ($this->current_task == $action){
				if(!is_numeric($this->progress)) $this->progress = 0;
				$menu .= '<div id="progressbar"><span class="install_label">'.$this->progress.'%</span></div><ul>';
				if (count($this->order) > 1) {
					foreach($this->order as $step) {
						$class = (in_array($step, $this->done)) ? 'done' : 'notactive';
						if(in_array(array_search($step, $this->order), $this->done)) $class .= ' done2';
						if($step == $this->current_step) $class = 'now';
						$menu .= "\n\t\t\t\t\t".'<li class="'.$class.'" id="'.$step.'"><span>'.$this->lang[$step].'<input type="hidden" name="select" id="back_'.$step.'" disabled="disabled" value="'.$step.'" /></span></li>';
					}
				}
				$menu .= '</ul>';
			}
		}
		
		return $menu;
	}
	
	private function lang_drop() {
		$drop = '<select name="inst_lang" id="language_drop">';
		$options = array();
		$files = sdir($this->root_path.'language');
		foreach($files as $file) {
			if(file_exists($this->root_path.'language/'.$file.'/lang_install.php')) $options[] = $file;
		}
		sort($options);
		foreach($options as $option) {
			$selected = ($this->in->get('inst_lang', 'english') == $option) ? ' selected="selected"' : '';
			$drop .= '<option value="'.$option.'"'.$selected.'>'.ucfirst($option).'</option>';
		}
		return $drop.'</select>';
	}
	
	private function show() {
		if(class_exists($this->current_step)) {
			$_step = registry::register($this->current_step);
		}
		$this->progress = round(100*(count($this->done)/count($this->order)), 0);
		if(!is_numeric($this->progress) || is_nan($this->progress)) $this->progress = 0;
		$content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		
		<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/core/core.min.css" />
		<script type="text/javascript" language="javascript" src="../libraries/jquery/core/core.min.js"></script>
		<link href="../libraries/FontAwesome/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" media="screen" href="style/install.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="style/jquery_tmpl.css" />
		<script type="text/javascript">
			//<![CDATA[
		$(function() {
			$("#language_drop").change(function(){
				$("#form_install").submit();
			});
			$("#progressbar").progressbar({
				value: '.$this->progress.'
			});
			$(".done, .done2, #previous_step").click(function(){
				$("#back_"+$(this).attr("id")).removeAttr("disabled");
				$("#form_install").submit();
			});
						
			$(".action").click(function(){
				$("#current_task").val($(this).attr("id"));
				$("#current_step").val("start");
				$("#form_install").submit();
			});			
			
			'.$_step->head_js.'
		});
			//]]>
		</script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>'.$this->lang['page_title'].'</title>
	</head>

	<body>
		<form action="index.php" method="post" id="form_install">
		<div id="outerWrapper">
			<div id="header">
				<img src="style/logo.svg" id="logo" />
				<div id="languageselect"><i class="fa fa-globe"></i> '.$this->lang['language'].': '.$this->lang_drop().'</div>
				<div id="logotext">'.$this->lang['page_title'].'</div>
			</div>
				
		<div id="installer">
			<div id="steps">
				<ul class="steps">'.$this->gen_menu().'
				</ul>
			</div>
			<div id="main">
				<div id="content">
					';
		if($this->pdl->get_log_size(DEBUG) > 0) {
			$error = $this->pdl->get_html_log(DEBUG)."<br />";
			$error = str_replace('install_error:', '', $error);
			$error = str_replace('install_warning:', '', $error);
			$error = str_replace('install_success:', '', $error);
			$error = str_replace('install_text:', '', $error);
			$content .= '<h1 class="hicon home">'.$this->lang[$this->in->get('current_step')].'</h1>'.$error;
		}

		$content .= '
					<h1 class="hicon home">'.$this->lang[$this->current_step].'</h1>
					'.$this->get_content().'
					<div class="buttonbar">';
		if($this->previous != 'start' && $this->current_step != 'end' && $this->current_step != "applicationstart") $content .= '
						<button id="previous_step" class="prevstep"><i class="fa fa-mail-reply"></i> '.$this->lang['back'].'</button>
						<input type="hidden" name="prev" value="'.$this->previous.'" id="back_previous_step" disabled="disabled" />';
		if($_step->skippable) $content .= '
						<input type="submit" name="'.(($_step->parseskip) ? 'next' : 'skip').'" value="'.$this->lang['skip'].'" class="'.(($_step->parseskip) ? 'nextstep' : 'skipstep').'" />';
		if ($this->current_step != "applicationstart") $content .= '<button type="submit" name="next" /><i class="fa fa-arrow-right"></i> '.$this->next_button().'</button>';
		$content .= 	'
						<input type="hidden" name="current_step" value="'.(($this->current_step == 'applicationstart') ? 'start' : $this->current_step).'" id="current_step"/>
						<input type="hidden" name="current_task" value="'.$this->current_task.'" id="current_task"/>		
						<input type="hidden" name="install_done" value="'.implode(',', $this->done).'" />
						<input type="hidden" name="step_data" value="'.base64_encode(serialize($this->data)).'" />
					</div>
				</div>
			</div>
		</div>
		<div id="footer">
			<a href="http://eqdkp-plus.eu/">Version '.$this->version.' © 2006 - '.date('Y', time()).' by EQDKP Plus Development-Team</a>
		</div>
		</div>
		</form>
	</body>
</html>';
		echo $content;
	}
	
	public function install_error($log) {
		$title = (isset($log['args'][1])) ? $log['args'][1] : $this->lang['error'];

		return '<div class="infobox infobox-large infobox-red clearfix">
		<i class="fa fa-exclamation-triangle fa-4x pull-left"></i><strong>'.$title.'</strong><br /> '.$log['args'][0].'
	</div>';

	}
	
	public function install_warning($log) {
		$title = (isset($log['args'][1])) ? $log['args'][1] : $this->lang['warning'];
		
		return '<div class="infobox infobox-large infobox-red clearfix">
			<i class="fa fa-exclamation-triangle fa-4x pull-left"></i><strong>'.$title.'</strong><br />'.$log['args'][0].'
		</div>';
	}
	
	public function install_success($log) {
		$title = (isset($log['args'][1])) ? $log['args'][1] : $this->lang['success'];
		
		return '<div class="infobox infobox-large infobox-green clearfix">
		<i class="fa fa-check fa-4x pull-left"></i><strong>'.$title.'</strong><br />'.$log['args'][0].'
	</div>';
	}
	
	public function install_text($log){
		return '<div>
		'.$log['args'][0].'
	</div>';
	}
}


abstract class step_generic extends gen_class {
	public static $before		= 'start';
	public static $ajax			= false; //name of the ajax-var if needed
	public $head_js		= '';
	public $next_button 		= 'continue';
	public $skippable			= false;
	public $parseskip			= false;
	
	public $data	= array();
	
	public function __construct() {
		$this->data = registry::register('supporttool')->data[get_class($this)];
	}
	
	public static function before() {
		return self::$before;
	}
	
	public static function ajax() {
		return self::$ajax;
	}

	abstract public function get_output();
	abstract public function get_filled_output();
	abstract public function parse_input();
}
?>