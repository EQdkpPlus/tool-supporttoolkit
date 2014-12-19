<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2011
 * Date:		$Date: 2014-02-10 18:52:30 +0100 (Mo, 10 Feb 2014) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 14041 $
 * 
 * $Id: ftp_access.class.php 14041 2014-02-10 17:52:30Z godmod $
 */
if(!defined('EQDKP_INC')) {
	header('HTTP/1.0 404 Not Found');exit;
}
class data extends step_generic {
	public static $shortcuts = array('pfh' => array('file_handler'));
	public static $before		= 'ftp_access';
	
	public static function before() {
		return self::$before;
	}

	public function get_output() {
		$dataFolder = $this->root_path.'data';
		$arrFolders = scandir($dataFolder);
		
		$content = '
		<div class="infobox infobox-large infobox-blue clearfix">
			<i class="fa fa-info-circle fa-4x pull-left"></i>'.$this->lang['datafolder_info'].'
		</div>
		
		<div>
			<select size="10" name="datafolder">';
		
		$oldFolder = array();
		foreach($arrFolders as $dataFolder){
			$file = $this->root_path.'data/'.$dataFolder;
			if (is_dir($file) && $file != "." && $file != ".." && $file != "index.html" && $file != ".htaccess"){
				if (is_file($file.'/eqdkp/config/localconf.php')){
					if ($dataFolder == md5($this->table_prefix.$this->dbname)) continue;
					$oldFolder[$dataFolder] = $dataFolder;
					$content .= '<option value="'.$dataFolder.'">'.$dataFolder.'</option>';
				}
			}
		}	
				
		$content .= '	
			</select>
		</div>';
		return $content;
	}

	public function get_filled_output() {
		return $this->get_output();
	}

	public function parse_input() {
		if (strlen($this->in->get('datafolder'))){
		
			//Rename Data Folder
			$this->pfh->Delete($this->root_path.'data/'.md5($this->table_prefix.$this->dbname));
			
			$a = $this->pfh->rename($this->root_path.'data/'.$this->in->get('datafolder').'/', $this->root_path.'data/'.md5($this->table_prefix.$this->dbname).'/');
			
			//Set server_path in config
			$path = str_replace('movetool/', '', registry::register('environment')->server_path);
			registry::register('config')->set('server_path', $path);
		
		} else {
			$this->pdl->log('install_error', $this->lang['datafolder_missing']);
			return false;
		}

		return true;
	}
}
?>