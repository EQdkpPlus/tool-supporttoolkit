<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2003
 * Date:		$Date: 2011-12-11 10:09:59 +0100 (So, 11 Dez 2011) $
 * -----------------------------------------------------------------------
 * @author		$Author: Godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 11528 $
 * 
 * $Id: licence.class.php 11528 2011-12-11 09:09:59Z Godmod $
 */
if(!defined('EQDKP_INC')) {
	header('HTTP/1.0 404 Not Found');exit;
}
class zzz_delete extends step_generic {
	public $next_button = 'delete';
	
	public function get_output() {
		$strOut =  $this->lang['deletion_text'];
	
		return $strOut;
	}
	
	public function get_filled_output() {
		$strOut =  $this->lang['deletion_text'];
	
		return $strOut;
	}
	
	public function parse_input() {
		//Delete yourself
		$pfh = registry::register('file_handler', array('installer'));
		$pfh->Delete($this->root_path.'supporttool/');
		
		header('Location: '.$this->root_path.'index.php');
		exit;
	}
}
?>