<?php
 /*
 * Project:     EQdkp-Plus
 * License:     Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:       2002
 * -----------------------------------------------------------------------
 * @copyright   2006-2011 EQdkp-Plus Developer Team
 * @link        http://eqdkp-plus.com
 * @package     eqdkp-plus
 * 
 */
 
if (!defined('EQDKP_INC')) {
	die('You cannot access this file directly.');
}

//Language: English 2.0	
//Created by EQdkp Plus Translation Tool on  2014-02-20 09:20
//File: language/english_2.0/lang_install.php
//Source-Language: german_2.0

$lang = array( 
	"moving"	=> 'Moving from another Host',
		
	"introduction" => 'This Task should help you moving EQdkp Plus from one to another host. You have to enter some data, and this task will check and write it to the right locations.<br />
	<h2>Guide</h2>
	<ol><li><b>Create Backup on old host</b><br />Before moving all data to the new Host, go to the Backup-Section in the Admin Panel of the EQdkp Plus Installation on the old host and create a new Database-Backup.</li>
	<br /><li><b>Move all data to the new host</b><br />Use a FTP-Program or the rsync-command to transfer the whole EQdkp Plus Installation from the old to the new host. Please make sure that you will copy the data-folder and the config.php in the root folder of the EQdkp Plus Installation</li>
	<br /><li><b>Create a new database</b><br />Create a database for the EQdkp Plus Installation, if you don\'t have it done yet. Of course you can use an existing one.</li>
	<br /><li><b>Start this task</b><br />Click on the "Proceed"-Button to start this task, which will guide you through the whole process.</li>
	</ol>
	',
		
	"readme" => 'Introduction',
	"php_check" => 'Requirements Check',
	"ftp_access" => 'FTP Settings',
	"encryptionkey" => 'Encryption Key',
	"data_folder" => 'Data Folder',
	"db_access" => 'Database Access',
	"inst_settings" => 'Settings',
	"admin_user" => 'Administrator Account',
	"end" => 'Complete the installation',
	"welcome" => 'Welcome to the installer for EQdkp Plus. We have worked hard to make this process easy and fast. To get started simply accept our license agreement by clicking \'Accept & Start Installation\' below.',
	"accept" => 'Accept & Start Installation',
	"license_text" => '<b>EQdkp Plus is published under Creative Commons Licence "Attribution-NonCommercial-ShareAlike 3.0 Unported (CC BY-NC-SA 3.0)".</b><br /><br /> The full licence text can be found at https://creativecommons.org/licenses/by-nc-sa/3.0/legalcode.<br /><br />
	This is a human-readable summary of the Legal Code:<br /><br />
	<b>You are free:</b><ul><li><b>to Share</b> — to copy, distribute and transmit the work </li><li><b>to Remix</b> — to adapt the work </li></ul>
	<b>Under the following conditions:</b><ul><li><b>Attribution</b> — You must attribute the work in the manner specified by the author or licensor (but not in any way that suggests that they endorse you or your use of the work).</li><li><b>Noncommercial</b> — You may not use this work for commercial purposes. </li><li><b>Share Alike</b> — If you alter, transform, or build upon this work, you may distribute the resulting work only under the same or similar license to this one. </li></ul>
	<b>With the understanding that: </b><ul><li><b>Waiver</b> — Any of the above conditions can be waived if you get permission from the copyright holder. </li><li><b>Public Domain</b> — Where the work or any of its elements is in the public domain under applicable law, that status is in no way affected by the license. </li><li><b>Other Rights</b> — In no way are any of the following rights affected by the license: <ul><li>Your fair dealing or fair use rights, or other applicable copyright exceptions and limitations; </li><li>The author\'s moral rights; </li><li>Rights other persons may have either in the work itself or in how the work is used, such as publicity or privacy rights. </li></ul> </li><li><b>Notice</b> — For any reuse or distribution, you must make clear to others the license terms of this work. The best way to do this is with a link to this web page (https://creativecommons.org/licenses/by-nc-sa/3.0/). </li></ul>
',
	"table_pcheck_name" => 'Name',
	"table_pcheck_required" => 'Required',
	"table_pcheck_installed" => 'Current',
	'table_pcheck_rec'		=> 'Rec.',
	"module_php" => 'PHP version',
	"module_mysql" => 'MySQL database',
	"module_zLib" => 'zLib PHP module',
	"module_safemode" => 'PHP Safemode',
	"module_curl" => 'cURL PHP module',
	"module_fopen" => 'fopen PHP function',
	"module_soap" => 'SOAP PHP module',
	"module_autoload" => 'spl_autoload_register PHP function',
	"module_hash" => 'hash PHP function',
	"module_memory" => 'PHP memory limit',
	'module_json'			=> 'JSON PHP module',
	"safemode_warning" => '<strong>WARNING</strong><br/>Because the PHP Safe mode is active, you have to use the FTP mode in the next Step in order to use EQdkp Plus!',
	"phpcheck_success" => 'The minimum requirements for the installation of EQDKP-Plus are met. The installation can proceed.',
	"phpcheck_failed" => 'The minimum requirements for the installation of EQDKP-Plus are not met.<br />A selection of suitable hosting companies can be found on our <a href="http://eqdkp-plus.eu" target="_blank">website</a>',
	"do_match_opt_failed" => 'Some recommends are not met. EQDKP-Plus will work on this system; however, maybe not all features will be available.',
	"ftphost" => 'FTP host',
	"ftpport" => 'FTP port',
	"ftpuser" => 'FTP username',
	"ftppass" => 'FTP password',
	"ftproot" => 'FTP base dir',
	"ftproot_sub" => '(Path to the root directory of the FTP user)',
	"useftp" => 'Use FTP mode as file handler',
	"useftp_sub" => '(You can change it later by editing the config.php)',
	"safemode_ftpmustbeon" => 'Since PHP safe mode is on, the FTP details must be completed to continue the installation.',
	"ftp_connectionerror" => 'The FTP connection could not be established. Please check the FTP host and the FTP port.',
	"ftp_loginerror" => 'The FTP login was not successful. Please check your FTP username and FTP password.',
	"plain_config_nofile" => 'The file <b>config.php</b> is not available and automatic creation failed. <br />Please create a blank text file with the name <b>config.php</b> and set the permissions with chmod 777',
	"plain_config_nwrite" => 'The <b>config.php</b> file is not writeable. <br /> Please set the correct permissions. <b>chmod 0777 config.php</b>.',
	"plain_dataf_na" => 'The folder <b>'.registry::get_const('root_path').'data/</b> is not available.<br /> Please create this folder. <b>mkdir data</​​b>.',
	"plain_dataf_nwrite" => 'The folder <b>'.registry::get_const('root_path').'data/</b> is not writeable.<br /> Please set the correct permissions. <b>chmod -R 0777 data</​​b>.',
	"ftp_datawriteerror" => 'The Data folder could not be written to. Is the FTP root path set  correctly?',
	"ftp_info" => 'To improve security and functionality, you can choose to allow an ftp account of your choosing to perform file interactions on the server. This reduces the need to use more open server permissions, and may be required on some hosting configurations. To use this optional setting please provide a ftp user with permissions to access your installation, and select the \'FTP Mode\' tick box. If you are not using FTP Mode you may simply select proceed on this page.',
	"ftp_tmpinstallwriteerror" => 'The folder <b>'.registry::get_const('root_path').'data/97384261b8bbf966df16e5ad509922db/tmp/</b> is not writable.<br />To write the config-file, CHMOD 777 is required. This folder will be deleted after the installation process.',
	"ftp_tmpwriteerror" => 'The folder <b>'.registry::get_const('root_path').'data/%s/tmp/</b> is not writable.<br />Using FTP-Mode requires CHMOD 777 for this folder. This is the only folder needing writing permissions.',
	"dbtype" => 'Database type',
	"dbhost" => 'Database host',
	"dbname" => 'Database name',
	"dbuser" => 'Database username',
	"dbpass" => 'Database password',
	"table_prefix" => 'Prefix for EQDKP-Plus tables',
	"test_db" => 'Test database',
	"prefix_error" => 'No or invalid database prefix specified! Please enter a valid prefix.',
	"dbname_error" => 'No database name specified! Please enter a valid database name.',
	"INST_ERR_PREFIX" => 'An EQdkp installation with that prefix already exists. Delete all tables with that prefix and repeat this step once you have used the "Back" button. Alternatively, you can choose a different prefix, e.g. if you want to install multiple sets of EQDKPlus data in a database.',
	"INST_ERR_DB_CONNECT" => 'Could not connect to the database, see error message below.',
	"INST_ERR_DB_NO_ERROR" => 'No error message given.',
	"INST_ERR_DB_NO_MYSQLI" => 'The version of MySQL installed on this machine is incompatible with the “MySQL with MySQLi Extension” option you have selected. Please try the “MySQL” option instead.',
	"INST_ERR_DB_NO_NAME" => 'No database name specified.',
	"INST_ERR_PREFIX_INVALID" => 'The table prefix you have specified is invalid for your database. Please try another, removing characters such as hyphen, apostrophe or forward- or back-slashes.',
	"INST_ERR_PREFIX_TOO_LONG" => 'The table prefix you have specified is too long. The maximum length is %d characters.',
	"dbcheck_success" => 'The database was checked. It found no errors or conflicts. The installation can be continued safely.',
	"inst_db" => 'Install database',

	"install_end_text" => 'The moving process was completed successfully. You can now use your EQdkp Plus Installation.',
	
	
	//Backup step
	"backup"	=> "Database-Backup",
	"backup_info"	=> "Please select a Backup that should be imported. Backups marked with * are Backups with all tables.",
	"backup_success" => "The Backup was successfully imported.",
	"backup_usertable_404" => "Could not found Usertable. Please make sure that you have imported a Database Backup from the old host.",
	
	//Data folder
	"data"	=> "Data-Folder",
	"datafolder_info" => "Please select the data-Folder of your old installation. You can view the name of the old folder when inserting the Admin Panel of your old Installation and clicking on the 'Statistics'-Tab. Normally, in the following selectbox there should be only one Folder.",
	"datafolder_missing" => "Please select the data-Folder of your old EQdkp Plus installation."
	);

?>