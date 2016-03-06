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