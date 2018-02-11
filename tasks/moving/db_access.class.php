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
class db_access extends step_generic {
	public static $shortcuts = array('pfh' => array('file_handler', array('installer')));

	public $next_button		= 'test_db';
	
	public static $before 		= 'php_check';

	public static function before() {
		return self::$before;
	}

	//default settings
	private $dbtype			= 'mysqli';
	private $dbhost			= 'localhost';
	private $dbname			= '';
	private $dbuser			= '';

	public function get_output() {
		$content = '
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="no-borders">
			<tr>
				<td width="40%" align="right"><strong>'.$this->lang['dbtype'].':</strong></td>
				<td width="60%">
					<select name="dbtype" class="input">
					';
		// Build the database drop-down
		include_once($this->root_path.'libraries/dbal/dbal.class.php');
		foreach ( dbal::available_dbals() as $db_type => $db_name ){
			$selected = ($db_type == $this->dbtype) ? ' selected="selected"' : '';
			$content .= '	<option value="'.$db_type.'"'.$selected.'>'.$db_name.'</option>
					';
		}
		$content .= '</select>
				</td>
			</tr>
			<tr>
				<td align="right"><strong>'.$this->lang['dbhost'].': </strong></td>
				<td><input type="text" name="dbhost" size="25" value="'.$this->dbhost.'" class="input" /></td>
			</tr>
			<tr>
				<td align="right"><strong>'.$this->lang['dbname'].': </strong></td>
				<td><input type="text" name="dbname" size="25" value="'.$this->dbname.'" class="input" /></td>
			</tr>
			<tr>
				<td align="right"><strong>'.$this->lang['dbuser'].': </strong></td>
				<td><input type="text" name="dbuser" size="25" value="'.$this->dbuser.'" class="input" /></td>
			</tr>
			<tr>
				<td align="right"><strong>'.$this->lang['dbpass'].': </strong></td>
				<td><input type="password" name="dbpass" size="25" value="" class="input" /></td>
			</tr>
		</table>';
		return $content;
	}
	public function get_filled_output() {
		$this->dbtype = registry::get_const('dbtype');
		$this->dbhost = registry::get_const('dbhost');
		$this->dbname = registry::get_const('dbname');
		$this->dbuser = registry::get_const('dbuser');
		return $this->get_output();
	}

	public function parse_input() {
		$this->dbtype		= $this->in->get('dbtype');
		$this->dbhost		= $this->in->get('dbhost', $this->dbhost);
		$this->dbname		= $this->in->get('dbname');
		$this->dbuser		= $this->in->get('dbuser');
		$this->dbpass		= $this->in->get('dbpass', '', 'raw');

		// Check database name
		if ($this->dbname == ""){
			$this->pdl->log('install_error', $this->lang['dbname_error']);
			return false;
		}

		$error = array();
		include_once($this->root_path.'libraries/dbal/dbal.class.php');
		try {
			if($this->dbtype === 'mysql') $this->dbtype == 'mysqli';
			$db = dbal::factory(array('dbtype' => $this->dbtype));
			$db->connect($this->dbhost, $this->dbname, $this->dbuser, $this->dbpass);
		
		} catch(DBALException $e){
			$this->pdl->log('install_error', $e->getMessage());
			return false;
		}
		
		
		$this->pdl->log('install_success', $this->lang['dbcheck_success']);
		
		//Before writing the config-file, we have to check the writing-permissions of the tmp-folder
		if($this->use_ftp && !$this->pfh->testWrite()){
			$this->pdl->log('install_error', sprintf($this->lang['ftp_tmpwriteerror'], $this->pfh->get_cachefolder(true)));
			return false;
		}
		
		$this->configfile_fill();
		registry::$aliases['db'] = 'dbal_'.$this->dbtype;
		include_once($this->root_path.'libraries/dbal/'.$this->dbtype.'.dbal.class.php');
		return true;
	}

	private function configfile_fill() {
		$content = file_get_contents($this->root_path.'config.php');		
		$content = preg_replace('/\$(dbtype) = \'(.*)\';/m', "{{INSERT}}", $content);
		$content = preg_replace('/\$(dbtype|dbhost|dbname|dbuser|dbpass) = \'(.*)\';/m', "", $content);
		$content = preg_replace('/\\n{3,}/', "\n\n", $content);
		
		$c = '$dbtype = \''.$this->dbtype.'\';'."\n";
		$c .= '$dbhost = \''.$this->dbhost.'\';'."\n";
		$c .= '$dbname = \''.$this->dbname.'\';'."\n";
		$c .= '$dbuser = \''.$this->dbuser.'\';'."\n";
		$c .= '$dbpass = \''.$this->dbpass.'\';';
		$content = str_replace("{{INSERT}}", $c, $content);

		$this->pfh->putContent($this->root_path.'config.php', $content);
	}
}
?>