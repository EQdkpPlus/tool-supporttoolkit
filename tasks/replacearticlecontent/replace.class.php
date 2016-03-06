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
class replace extends step_generic {
	public $next_button = 'continue';
	
	private $content;
	private $search;
	private $replace;
	
	public function get_output() {
		$content = $this->lang['replacearticlecontent_text'].'<br/>
		<table width="100%" border="0" cellspacing="1" cellpadding="2" class="no-borders">
			<tr>
				<td align="right"><strong>'.$this->lang['search_string'].': </strong></td>
				<td><input type="text" name="search" size="25" value="" class="input" /></td>
			</tr>
			<tr>
				<td align="right"><strong>'.$this->lang['replace_string'].': </strong></td>
				<td><input type="text" name="replace" size="25" value="" class="input" /></td>
			</tr>
		</table>';
		return $content;
	}
	
	public function get_filled_output() {
		$strOut =  $this->lang['tablerepair_text'];
	
		return $strOut;
	}
	
	public function parse_input() {
		$search = $this->in->get('search');
		$replace = $this->in->get('replace');
		if($search == ""){
			$content = $this->lang['search_empty'];
		} else {
			$this->db->prepare("UPDATE __articles SET text = REPLACE (text, ?, ?)")->execute($search, $replace);
			$content = $this->lang['replace_finished'];
		}

		$this->pdl->log('install_text', $content);
		return true;
	}
	
	
}
?>