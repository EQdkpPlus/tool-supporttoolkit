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
if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

$lang = array(
	'moving'				=> "Von einem anderen Host umziehen",
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
	
	//Step-Names
	'readme'				=> 'Einführung',
	'php_check'				=> 'Voraussetzungen',
	'ftp_access'			=> 'FTP-Einstellungen',
	'data_folder'			=> 'data-Ordner',
	'db_access'				=> 'Datenbank Zugang',
	'end'					=> 'Abschließen des Umzugs',
	
	//Step: readme
	"introduction" => 'Dieses Tool soll dabei helfen, ein EQdkp Plus System auf einen neuen Host umzuziehen. Dabei werden alle Voraussetzungen geprüft, notwendige Daten abgefragt und die richtigen Stellen angepasst.<br />
	<h2>Anleitung</h2>
	<ol><li><b>Backup der alten Installation erstellen</b><br />Vor dem Umzug solltest du auf der alten EQdkp Plus Installation ein Datenbank-Backup anfertigen. Gehe dazu in den Adminbereich des alten EQdkp Plus, wähle "Sicherung" aus, und erstelle dann ein Datenbank-Backup.</li>
	<br /><li><b>Daten auf den neuen Host kopieren</b><br />Benutze ein FTP-Programm oder den rsync Konsolenbefehl, um die Daten auf den neuen Host zu kopieren. Stelle bitte sicher, dass du alle Daten, also auch den data-Ordner und die config.php mit kopierst.</li>
	<br /><li><b>Neue Datenbank erstellen</b><br />Wenn du noch keine Datenbank am neuen Host erstellst hast, dann ist jetzt der richtige Zeitpunkt dafür. Du kannst aber auch eine bereits vorhandene Datenbank am neuen Host verwenden.</li>
	<br /><li><b>Umzugs-Tool ausführen</b><br />Nun solltest du dieses Tool ausführen. Klicke dazu unten auf den "Fortfahren"-Button.</li>
	</ol>
	',
	
	//Step: php_check
	'table_pcheck_name'		=> 'Name',
	'table_pcheck_required'	=> 'Benötigt',
	'table_pcheck_installed'=> 'Vorhanden',
	'table_pcheck_rec'		=> 'Empfohlen',
	'module_php'			=> 'PHP-Version',
	'module_mysql'			=> 'MySQL Datenbank',
	'module_zLib'			=> 'zLib PHP-Modul',
	'module_safemode'		=> 'PHP Safe Mode',
	'module_curl'			=> 'cURL PHP-Modul',
	'module_fopen'			=> 'fopen PHP-Funktion',
	'module_soap'			=> 'SOAP PHP-Modul',
	'module_autoload'		=> 'spl_autoload_register PHP-Funktion',
	'module_hash'			=> 'hash PHP-Funktion',
	'module_memory'			=> 'PHP Speicherlimit',
	'module_json'			=> 'JSON PHP-Modul',
	'safemode_warning'		=> '<strong>ACHTUNG</strong><br/>Da der  PHP Safe Mode aktiv ist, musst du im nächsten Schritt den FTP-Modus nutzen, ansonsten kann EQdkp Plus nicht verwendet werden!',
	'phpcheck_success'		=> 'Die Mindestanforderungen für die Installation von EQDKP-PLUS werden erfüllt. Die Installation kann fortgesetzt werden.',
	'phpcheck_failed'		=> 'Die Mindestanforderungen für die Installation von EQDKP-PLUS werden leider nicht erfüllt.<br />Eine Auswahl von geeigneten Hostern findest Du auf unserer <a href="'.EQDKP_PROJECT_URL.'" target="_blank">Website</a>',
	'do_match_opt_failed'	=> 'Es werden nicht alle Empfehlungen erfüllt. EQDKP-PLUS wird zwar auf diesem System funktionieren, jedoch eventuell mit Einschränkungen.',
	
	//Step: ftp access
	'ftphost'				=> 'FTP-Host',
	'ftpport'				=> 'FTP-Port',
	'ftpuser'				=> 'FTP-Benutzername',
	'ftppass'				=> 'FTP-Passwort',
	'ftproot'				=> 'Stammverzeichnis',
	'ftproot_sub'			=> '(Pfad zum Wurzelverzeichnis (root) des FTP-Benutzers)',
	'useftp'				=> 'FTP als Datei-Handler verwenden',
	'useftp_sub'			=> '(Kann nachträglich über die config.php de-/aktiviert werden)',
	'safemode_ftpmustbeon'	=> 'Da der PHP Safe Mode an ist, müssen die FTP Daten ausgefüllt werden um mit der Installation fortzufahren.',
	'ftp_connectionerror'	=> 'Die FTP-Verbindung konnte nicht hergestellt werden. Bitte überprüfe den FTP-Host und FTP-Port.',
	'ftp_loginerror'		=> 'Der FTP-Login war nicht erfolgreich. Bitte überprüfe den FTP-Benutzernamen und das FTP-Kennwort.',
	'plain_config_nofile'	=> 'Die Datei <b>config.php</b> ist nicht vorhanden und das automatische Anlegen ist fehlgeschlagen.<br />Bitte erstelle eine leere Textdatei mit dem namen <b>config.php</b> mit chmod 777 und lade sie hoch.',
	'plain_config_nwrite'	=> 'Die Datei <b>config.php</b> ist nicht beschreibbar.<br />Bitte die Berechtigung richtig setzen. <b>chmod 0777 config.php</b>.',
	'plain_dataf_na'		=> 'Der Ordner <b>./data/</b> ist nicht vorhanden.<br />Bitte erstelle ihn. <b>mkdir data</b>.',
	'plain_dataf_nwrite'	=> 'Der Ordner <b>./data/</b> ist nicht beschreibbar.<br />Bitte die Berechtigung richtig setzen. <b>chmod -R 0777 data</b>.',
	'ftp_datawriteerror'	=> 'Der Data Ordner konnte nicht beschrieben werden. Ist der FTP Root path richtig?',
	'ftp_info'				=> 'Anstatt bestimmten EQdkp Plus Dateiordnern Schreibrechte zu geben, kannst du einen FTP-Benutzer deines Servers benutzen, was die Sicherheit als auch die Funktionalität deines EQdkp Plus erhöht.',
	'ftp_tmpinstallwriteerror' => 'Der Ordner <b>./data/97384261b8bbf966df16e5ad509922db/tmp/</b> ist nicht beschreibbar.<br />Damit die Konfigurations-Datei geschrieben werden kann, ist CHMOD 777 notwendig. Dieser Ordner wird nach der Installation entfernt.',
	'ftp_tmpwriteerror' 	=> 'Der Ordner <b>./data/%s/tmp/</b> ist nicht beschreibbar.<br />Damit der FTP-Modus verwendet werden kann, ist CHMOD 777 für diesen Ordner notwendig. Dies ist der einzige Ordner, für den Schreibrechte benötigt werden.',
	
			
	//Step: db_access
	'dbtype'				=> 'Datenbanktyp',
	'dbhost'				=> 'Datenbankhost',
	'dbname'				=> 'Datenbankname',
	'dbuser'				=> 'Datenbank Benutzername',
	'dbpass'				=> 'Datenbank Passwort',
	'table_prefix'			=> 'Präfix für die EQdkp Tabellen',
	'test_db'				=> 'Datenbank testen',
	'prefix_error'			=> 'Kein oder ungültiges Datenbank Präfix angegeben! Bitte gib ein gültiges Präfix an.',
	'INST_ERR_PREFIX'		=> 'Eine EQdkp Installation mit diesem Präfix existiert bereits. Lösche alle Tabellen mit diesem Präfix und wiederhole diesen Schritt. Alternativ kannst du ein anderes Präfix wählen, wenn du z.B. mehrere EQDKP Plus-Installation in einer Datenbank nutzen willst.',
	'INST_ERR_DB_CONNECT'	=> 'Konnte keine Verbindung mit der Datenbank herstellen, siehe untenstehende Fehlermeldung.',
	'INST_ERR_DB_NO_ERROR'	=> 'Keine Fehlermeldung angegeben.',
	'INST_ERR_DB_NO_MYSQLI'	=> 'Die auf dieser Maschine installierte Version von MySQL ist nicht kompatibel mit der ausgewählten MySQL with MySQLi Extension Option. Bitte versuche stattdessen MySQL.',
	'INST_ERR_DB_NO_NAME'	=> 'Kein Datenbankname angegeben.',
	'INST_ERR_PREFIX_INVALID'	=> 'Der angegebene Datenbank-Prefix ist für diesen Datenbanktyp nicht gültig. Bitte versuche einen anderen, entferne alle Zeichen wie Bindestriche, Apostrophe, Slashes oder Backslashes.',
	'INST_ERR_PREFIX_TOO_LONG'	=> 'Der eingegebene Datenbankprefix ist zu lang. Die maximale Länge beträgt %d Zeichen.',
	'dbcheck_success'		=> 'Die Datenbank wurde überprüft. Es wurden keine Fehler oder Konflikte gefunden. Die Installation kann bedenkenlos fortgesetzt werden.',
	

	//Step: end
	'install_end_text'		=> 'Der Umzugs-Prozess ist nun beendet. Du kannst deine EQdkp Plus Installation nun verwenden.<br /><br />Wenn du den untenstehenden Button anklickst, wird sich das Tool aus Sicherheitsgründen automatisch entfernen.',
	
	//Backup step
	"backup"	=> "Datenbank-Backup",
	"backup_info"	=> "Bitte wähle das Backup des alten Host aus, dass importiert werden soll. Mit * markierte Backups enthalten alle gesicherten Tabellen.",
	"backup_success" => "Das Backup wurde erfolgreich importiert.",
	"backup_usertable_404" => "Kann keine Benutzertabelle finden. Bitte stelle sicher, dass du ein Datenbank-Backup des alten Host importiert hast.",
	
	//Data folder
	"data"	=> "Data-Ordner",
	"datafolder_info" => "Bitte wähle den data-Ordner der alten Installation aus. Den Namen des alten data-Ordners kannst du in deinem alten EQdkp Plus erfahren, wenn du auf die Startseite des Adminbereiches gehst, und den \"Statistik\"-Tab auswählst. Ansonsten sollte hier in der Regel nur ein Ordner aufgelistet werden.",
	"datafolder_missing" => "Please select the data-Folder of your old EQdkp Plus installation.",
	
	'windows_apache_hint'	=> 'Du scheinst als Webserver Apache unter Windows zu verwenden. EQdkp Plus wird in diesem Fall nur funktionieren, wenn du die ThreadStackSize auf 8388608 in der Apache-Konfiguration erhöhst.',
	
	
);
?>