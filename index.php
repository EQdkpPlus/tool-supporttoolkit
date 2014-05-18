<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2011
 * Date:		$Date: 2014-01-07 18:09:58 +0100 (Di, 07 Jan 2014) $
 * -----------------------------------------------------------------------
 * @author		$Author: godmod $
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 13872 $
 *
 * $Id: index.php 13872 2014-01-07 17:09:58Z godmod $
 */

// ---------------------------------------------------------
// Set up environment
// ---------------------------------------------------------
//
define('EQDKP_INC', true);
$eqdkp_root_path = './../';

ini_set("display_errors", 0);
define('DEBUG', 99);

include_once($eqdkp_root_path.'core/super_registry.class.php');
include_once($eqdkp_root_path.'core/registry.class.php');
include_once($eqdkp_root_path.'core/gen_class.class.php');
	
registry::add_const('root_path', $eqdkp_root_path);
registry::add_const('lite_mode', true);

// switch to userdefined error-handling
registry::$aliases['pdl'] = array('plus_debug_logger', array(false, false));
registry::$aliases['user'] = 'auth_db';
$pdl = registry::register('plus_debug_logger', array(false, false));
set_error_handler(array($pdl,'myErrorHandler'));
register_shutdown_function(array($pdl, "catch_fatals"));
$pdl->set_debug_level(DEBUG); //to prevent errors on further adding of debug-levels
unset($pdl);

registry::load_config(true);


//New DBAL
if($dbtype = registry::get_const('dbtype')) {
	include_once(registry::get_const('root_path') .'libraries/dbal/dbal.class.php');
	require_once(registry::get_const('root_path') . 'libraries/dbal/' . registry::get_const('dbtype') . '.dbal.class.php');
	registry::$aliases['db'] = array('dbal_'.registry::get_const('dbtype'), array(array('open' => true)));		
}

include_once($eqdkp_root_path . 'core/constants.php');
include_once($eqdkp_root_path . 'core/core.functions.php');
include_once($eqdkp_root_path . 'supporttool/supporttool.class.php');
registry::load_html_fields();
registry::register('supporttool')->init();

?>