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
class tablecheck extends step_generic {
	public $next_button = 'continue';
	
	private $content;
	
	public function get_output() {
		$strOut =  $this->lang['tablecheck_text'];
	
		return $strOut;
	}
	
	public function get_filled_output() {
		$strOut =  $this->lang['tablecheck_text'];
	
		return $strOut;
	}
	
	private function parse_sql_file($filename) {
		$file = file_get_contents($filename);
		$sqls = explode(";\n", str_replace("\n\n", "\n", str_replace("\r", "\n", $file)));
		$sqls = preg_replace('/^#.*$/m', '', $sqls);
		$sqls = preg_replace('/\s{2,}/', ' ', $sqls);
		//$sqls = preg_replace('/\v/', '', $sqls);
		return $sqls;
	}
	
	public function parse_input() {
		//Try to get install sql file and create new infrastructure
		$strInstallFile = $this->root_path.'install/schemas/mysql_structure.sql';
		$strTmpPrefix = 't'.substr(md5(rand()), 0, 7);

		if(is_file($strInstallFile)){
			$arrSQLs = $this->parse_sql_file($strInstallFile);
			foreach($arrSQLs as $strSQL){
				if($strSQL != "") $this->db->query(str_replace('__', $strTmpPrefix.'_', $strSQL));
			}
		} else {
			$content .= '<br/>
			<table class="colorswitch" style="border-collapse: collapse;">
			<tr><i class="fa fa-times-circle fa-2x negative"></i> This task needs the file install/schemas/mysql_structure.sql from your default installation. Please restore this file and make sure this script can access this file.
			</tr>
			</table>';
			$this->pdl->log('install_text', $content);
			return true;
		}

		$arrTables = $this->db->listTables();
		
		$strCurrentPrefix = registry::get_const('table_prefix');
		
		$arrNewColumns = array();
		$arrOldColumns = array();
		
		foreach($arrTables as $tablename){
			if(strpos($tablename, $strCurrentPrefix) === 0){
				$objStructure = $this->db->query("DESCRIBE ".$tablename.';');
				if($objStructure){
					$arrStructure = $objStructure->fetchAllAssoc();
					$arrOldColumns[str_replace($strCurrentPrefix, "", $tablename)] = $arrStructure;
				}
			}
			
			if(strpos($tablename, $strTmpPrefix) === 0){
				$objStructure = $this->db->query("DESCRIBE ".$tablename.';');
				if($objStructure){
					$arrStructure = $objStructure->fetchAllAssoc();
					$arrNewColumns[str_replace($strTmpPrefix.'_', "", $tablename)] = $arrStructure;
					$this->db->query("DROP TABLE ".$tablename.';');
				}
			}
		}
		$arrOldFields = array();
		$arrProblems = array();
		foreach($arrOldColumns as $strTablename => $arrStructure){
			
			foreach($arrStructure as $arrFields){
				$strField = $arrFields['Field'];
				$arrOldFields[$strTablename][$strField] = 1;
			}
		}
		
		foreach($arrNewColumns as $strTablename => $arrStructure){
			if(!isset($arrOldFields[$strTablename])){
				$arrProblems[] = "Table '".$strCurrentPrefix.$strTablename.'\' is missing.';
				continue;
			}
			
			$arrNewFields = array();
			foreach($arrStructure as $arrFields){
				$strField = $arrFields['Field'];
				if(!isset($arrOldFields[$strTablename][$strField])){
					$arrProblems[] = "Field '".$strField.'\' in Table \''.$strCurrentPrefix.$strTablename.'\' is missing.';
				}
			}
		}
		$content = "";

		if(count($arrProblems)){
			$content .= '<br/>
			<table class="colorswitch" style="border-collapse: collapse;">
			<tbody>';
			foreach($arrProblems as $strProblem){
				$content .= '<tr><i class="fa fa-times-circle fa-2x negative"></i> '.$strProblem.'</tr>';
			}
			$content .= '</tbody></table>';
		} else {
			$content .= '<br/>
			<table class="colorswitch" style="border-collapse: collapse;">
			<tr><i class="fa fa-check-circle fa-2x positive"></i> No problems found. Table structure seams fine.
			</tr>
			</table>';
		}
	
		
		$this->pdl->log('install_text', $content);
		return true;
	}
	
	
}
?>