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
 * $Id: db_access.class.php 14041 2014-02-10 17:52:30Z godmod $
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
		$content = substr(file_get_contents($this->root_path.'config.php'), 0, -2); //discard last two symbols (? >)
		$content = preg_replace('/^\$(dbtype) = \'(.*)\';$/m', "{{INSERT}}", $content);
		
		$content = preg_replace('/^\$(dbtype|dbhost|dbname|dbuser|dbpass) = \'(.*)\';$/m', "", $content);
		$content = preg_replace('/\\n{3,}/', "\n\n", $content);
		
		
		$c = '$dbtype = \''.$this->dbtype.'\';'."\n";
		$c .= '$dbhost = \''.$this->dbhost.'\';'."\n";
		$c .= '$dbname = \''.$this->dbname.'\';'."\n";
		$c .= '$dbuser = \''.$this->dbuser.'\';'."\n";
		$c .= '$dbpass = \''.$this->dbpass.'\';';
		$content = str_replace("{{INSERT}}", $c, $content);
		
		$content .= '?>';
		$this->pfh->putContent($this->root_path.'config.php', $content);
	}
}
?>