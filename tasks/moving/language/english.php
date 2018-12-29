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
	"license_text" => '<b>EQdkp Plus is published under AGPL v3.0 license.</b><br /><br /> The full license text can be found at <a href="http://opensource.org/licenses/AGPL-3.0" target="_blank">http://opensource.org/licenses/AGPL-3.0</a>.<br /><br />
	This is a summary of the most important terms of the AGPL v3.0. There is no claim to completeness and correctness.<br /><br />
	<h3><strong>You are permitted:</strong></h3>
<ul>
<li>to use this software for commercial use</li>
<li>to distribute this software</li>
<li>to modify this software</li>
</ul>
<h3><strong>You are required:</strong></h3>
<ul>
<li>to disclose the sourcecode of your complete application that uses EQdkp Plus, when you distribute your application</li>
<li>to disclose the sourcecode of your complete application that uses EQdkp Plus, if you don\'t distribute it, but users are using the software via network ("Hosting", "SaaS")</li>
<li>to remain the visible and unvisible Copyright Notices of this Project and to include a copy of the AGPL License at your application</li>
<li>to indicate significant changes made to the code</li>
</ul>
<h3><strong>It\'s forbidden:</strong></h3>
<ul>
<li>to held the author(s) of this software liable for any damages, the software is provided without warranty.</li>
<li>to license your application under another license than the AGPL</li>
</ul>',
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
	"dbport" => 'Database port',
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
	"datafolder_missing" => "Please select the data-Folder of your old EQdkp Plus installation.",
	"datafolder_notrequired" => "No selection required.",
	'windows_apache_hint'	=> 'It seems like you are using Apache under Windows as Webserver. EQdkp Plus will only work if you increase the ThreadStackSize to 8388608 at the Apache configuration file.',
	
	);

?>