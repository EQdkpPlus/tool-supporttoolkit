<?php
/*	Project:	EQdkp-Plus
 *	Package:	EQdkp-plus Supportool
 *	Link:		http://eqdkp-plus.eu
 *
 *	Copyright (C) 2006-2015 EQdkp-Plus Developer Team
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
			$path = str_replace('supporttool/', '', registry::register('environment')->server_path);
			registry::register('config')->set('server_path', $path);
		
		} else {
			$this->pdl->log('install_error', $this->lang['datafolder_missing']);
			return false;
		}

		return true;
	}
}
?>
