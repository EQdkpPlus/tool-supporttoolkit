<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2011
 * Date:		$Date: 2014-02-22 16:10:11 +0100 (Sa, 22 Feb 2014) $
 * -----------------------------------------------------------------------
 * @author		$Author: wallenium $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 14092 $
 * 
 * $Id: lang_install.php 14092 2014-02-22 15:10:11Z wallenium $
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'page_title'			=> "EQDKP-PLUS Support-Tool",
	'back'					=> 'Speichern und Zurück',
	'continue'				=> 'Fortfahren',
	'language'				=> 'Sprache',
	'inst_finish'			=> 'Umzug abschließen',
	'error'					=> 'Fehler',
	'warning'				=> 'Warnung',
	'success'				=> 'Erfolg',
	'yes'					=> 'Ja',
	'no'					=> 'Nein',
	'retry'					=> 'Erneut versuchen',
	'skip'					=> 'Überspringen',
	'step_order_error'		=> 'Step-Order Fehler: Step nicht gefunden. Bitte überprüfe, ob alle Dateien richtig hochgeladen wurden. Für weitere Hilfe besuche bitte unser Forum unter <a href="'.EQDKP_BOARD_URL.'">'.EQDKP_BOARD_URL.'</a>.',
	
	'tasks'					=> 'Aufgabe auswählen',
	'applicationstart'		=> 'Willkommen beim EQdkp Plus Support Tool!',
	"start_text" => 'Dieses Support-Tool bietet verschiedene Aufgaben zur Wartungs Deines EQdkp Plus-Systems. So unterstützt es dich z.B. bei einem Host-Umzug oder bei der Reperatur von defekten Tabellen.<br/>Wenn Du dieses Tool nicht mehr benötigst, lösche es bitte von deinem Host.<br /><br />Bitte wähle auf der linken Seite eine Aufgabe aus.
	',
);
?>