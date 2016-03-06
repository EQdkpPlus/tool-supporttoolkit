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
class repair extends step_generic {
	public $next_button = 'continue';
	
	private $content;
	
	public function get_output() {
		$strOut =  $this->lang['tablerepair_text'];
	
		return $strOut;
	}
	
	public function get_filled_output() {
		$strOut =  $this->lang['tablerepair_text'];
	
		return $strOut;
	}
	
	public function parse_input() {
		$arrTables = $this->db->listTables();
		
		$content .= '<br/>
		<table class="colorswitch" style="border-collapse: collapse;">
			<thead>
			<tr>
				<th width="33%">'.$this->lang['table_name'].'</th>
				<th width="33%">'.$this->lang['table_status'].'</th>
				<th width="33%">'.$this->lang['table_repaired'].'</th>
			</tr>
			</thead>
			<tbody>';
		$ok = '<i class="fa fa-check-circle fa-2x positive"></i>';
		$false = '<i class="fa fa-times-circle fa-2x negative"></i>';
		
		foreach($arrTables as $name){
			$arrResult = $this->db->query("CHECK TABLE ".$name, true);
			$blnRepairStatus = '-';
			if ($arrResult['Msg_text'] != "OK"){
				$arrRepairResult = $this->db->query("REPAIR TABLE ".$name, true);
				if ($arrRepairResult['Msg_text'] == "OK") $blnRepairStatus = $ok;
			}
				
			$content .= '<tr>
				<td>'.$name.'</td>
				<td>'.(($arrResult['Msg_text'] == "OK") ? $ok : $false).'</td>
				<td class="positive">'.$blnRepairStatus.'</td>
			</tr>';
		}
		
		$content .= '</table>';

		$this->pdl->log('install_text', $content);
		return true;
	}
	
	
}
?>