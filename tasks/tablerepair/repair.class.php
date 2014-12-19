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
				if ($arrRepairResult['Msg_text'] != "OK") $blnRepairStatus = $ok;
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