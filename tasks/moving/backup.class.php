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
class backup extends step_generic {
	public static $shortcuts = array('pfh' => array('file_handler', array('installer')));
	public static $before		= 'db_access';
	
	public $skippable = true;
	
	public static function before() {
		return self::$before;
	}

	public function get_output() {
		$dataFolder = $this->root_path.'data';
		$arrFolders = scandir($dataFolder);
		
		$files = $backups = array();
		foreach($arrFolders as $dataFolder){
			$files = array();
			$file = $this->root_path.'data/'.$dataFolder;
			if (is_dir($file) && $file != "." && $file != ".." && $file != "index.html" && $file != ".htaccess"){
				//Read out all of our backups
				$path = $file.'/eqdkp/backup/';
				if($dir=opendir($path)){
					while($file=readdir($dir)){
						if (!is_dir($file) && $file != "." && $file != ".." && $file != "index.html" && $file != ".htaccess"){
							$files[$file]=$file;
						}
					}
					closedir($dir);
				}
						
				//Generate backup-array, only list eqdkp-backups
				foreach ($files as $elem){
					if (preg_match('#^eqdkp-backup_([0-9]{10})_([0-9a-zA-Z]{1,32})\.(sql|zip?)$#', $elem, $matches)){
						$backups[$path.$elem] = $matches[1];
					}
					if (preg_match('#^eqdkp-fbackup_([0-9]{10})_([0-9a-zA-Z]{1,32})\.(sql|zip?)$#', $elem, $matches)){
						$backups[$path.$elem] = $matches[1];
						$full[] = $elem;

					}

				}
				if (isset($backups) && is_array($backups)){
					//Sort the arrays the get the newest ones on top
					array_multisort($backups, SORT_DESC);
				}
				
				
				
			}
		}

		$js_output = '';
		//Brink the Backups to template
		
		$content = '<div class="infobox infobox-large infobox-blue clearfix">
			<i class="fa fa-info-circle fa-4x pull-left"></i>'.$this->lang['backup_info'].'
		</div><br />
		
		<div><div style="float:left;"><select size="10" name="backups" onchange="show_metadata(this.value)">';
		
		if (isset($backups) && is_array($backups)){
			foreach ($backups as $key=>$elem){
				$metaFolder = str_replace("/eqdkp/backup/", "/eqdkp/backup/meta/", $key);
				$metaFolder = str_replace(array(pathinfo($key, PATHINFO_FILENAME), '.'.pathinfo($key, PATHINFO_EXTENSION)), "", $metaFolder);
				$metaFile = pathinfo($key, PATHINFO_FILENAME).'.meta.php';
			
				if ($metaFolder.$metaFile){

					$result = @file_get_contents($metaFolder.$metaFile);
					if($result !== false){
						$metadata[$key] = unserialize($result);
					}
				}
				$addition = '';

				if (!in_array($key, $full)){
					$addition = '*';
				}
				
				$content .= '<option value="'.$key.'">'.date("Y-m-d H:i", $elem).$addition.'</option>';

				if (is_array($metadata[$key])){

					$js_output .= 'metadata["'.$key.'"]= "<b>Name</b>: '.pathinfo($key, PATHINFO_FILENAME).'.'.pathinfo($key, PATHINFO_EXTENSION).'<br /><b>Date:</b> '.date("Y-m-d H:i", $elem).'<br /><b>EQdkp-Version:</b> '.$metadata[$key]['eqdkp_version'].'<br /><b>Table Prefix:</b> '.$metadata[$key]['table_prefix'].'<br /><b>Tables:</b> ';
					if ($metadata[$key]['uncomplete']){
						$js_output .= '<ul>';
						foreach ($metadata[$key]['tables'] as $table){
							$js_output .= '<li>'.$table.'</li>';
						}
						$js_output .= '</ul>';
					} else {
						$js_output .= 'All';
					}
					$js_output .= '";';

				} else {
					$js_output .= 'metadata["'.$key.'"]= "No Metadata available";';
				}

			}
		}
		
		$content .= '</select></div>
				<div style="float:left; margin-left: 20px; max-width: 300px; word-wrap: break-word;"><b>Description:</b><br />
      <br /><div id="metadata"></div></div></div><div style="clear:both;"></div>
	  
	  <script>
		function show_metadata(value){
				var metadata = new Array();
				'.$js_output.'
				$("#metadata").html(metadata[value]);
		}
	  </script>
	  
	  ';

		return $content;
	}

	public function get_filled_output() {
		return $this->get_output();
	}

	public function parse_input() {
		if(strlen($this->in->get('backups'))){
			$file = $this->in->get('backups');
			$file_name = pathinfo($file, PATHINFO_FILENAME).'.'.pathinfo($file, PATHINFO_EXTENSION);			
			
			if (preg_match('#^eqdkp-backup_([0-9]{10})_([0-9a-zA-Z]{1,32})\.(sql|zip?)$#', $file_name, $matches) || preg_match('#^eqdkp-fbackup_([0-9]{10})_([0-9a-zA-Z]{1,32})\.(sql|zip?)$#', $file_name, $matches)){
				switch ($matches[3])
				{
					case 'sql':
						$fp = fopen($file, 'rb');
					break;

					case 'zip':
						//Copy the archive to the tmp-folder
						$new_file = $this->pfh->FolderPath('backup/tmp', 'eqdkp').$file_name;
						$this->pfh->copy($file,  $new_file);
						$base = pathinfo($file_name);
						$archive = registry::register('zip', array($new_file));
						$archive->extract($this->pfh->FolderPath('backup/tmp', 'eqdkp'), array($base['filename'].'.sql'));

						//Now extract the data-Folder and replace existing files
						/*
						if ($this->in->get('restore_data', 0) == 1){
							$archive->extract($this->root_path);
							$this->pfh->Delete($this->root_path.$base['filename'].'.sql');
						}
						*/

						$this->pfh->Delete($new_file);
						$backup_file = $this->pfh->FolderPath('backup/tmp', 'eqdkp').$base['filename'].'.sql';

						$fp = fopen($backup_file, 'rb');
					break;
				}
				
				$read = 'fread';
				$seek = 'fseek';
				$eof = 'feof';
				$close = 'fclose';
				$fgetd = 'fgetd';
				@set_time_limit(0);
				
				while (($sql = $this->$fgetd($fp, ";\n", $read, $seek, $eof)) !== false){
					if (strpos($sql, "--") === false && $sql != ""){
						$this->do_sql($sql);
					}
				}

				//Flush cache
				$this->pdc->flush();
				
				//Success
				$this->pdl->log('install_success', $this->lang['backup_success']);
			}
		} else {
			//Check if user has imported the Database on its own.
			$objQuery = $this->db->query("Select * FROM __users");
			if (!$objQuery || $objQuery->affectedRows == 0){
					$this->pdl->log('install_error', $this->lang['backup_usertable_404']);
			}
			
		}
		
		
		return true;
	}

	
	// modified from PHP.net
	public function fgetd(&$fp, $delim, $read, $seek, $eof, $buffer = 8192){
		$record = '';
		$delim_len = strlen($delim);

		while (!$eof($fp)){
			$pos = strpos($record, $delim);
			if ($pos === false){
				$record .= $read($fp, $buffer);
				if ($eof($fp) && ($pos = strpos($record, $delim)) !== false){
					$seek($fp, $pos + $delim_len - strlen($record), SEEK_CUR);
					return trim(substr($record, 0, $pos));
				}
			}else{
				$seek($fp, $pos + $delim_len - strlen($record), SEEK_CUR);
				return trim(substr($record, 0, $pos));
			}
		}
		return false;
	}
	
	private function do_sql($sql) {
		if($sql && !$this->sql_error) {
			$objQuery = $this->db->query($sql.';');
			if (!$objQuery){		
				$this->pdl->log('install_error', 'SQL-Error:<br />Query: '.$sql.';<br />Code: '.$this->db->errno.'<br />Message: '.$this->db->error);
				$this->undo();
				$this->sql_error = true;
				return false;
			}
		}
		return true;
	}
}
?>