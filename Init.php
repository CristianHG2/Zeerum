<?php

/* Constants */

define('ROOT_DIR', str_replace('\\', '/', dirname(__FILE__)));
define('CONFIG_DIR', ROOT_DIR.'/config');
define('VIEWS_DIR', ROOT_DIR.'/views');
define('LIB_DIR', ROOT_DIR.'/lib');
define('ZEELIB', LIB_DIR.'/Zee');
define('DATA_DIR', ZEELIB.'/Data');
define('DEBUG', false);

/* Debug */

if ( DEBUG )
{
	error_reporting(-1);
	ini_set('display_errors', 'On');
	ini_set('display_startup_errors', 'On');
}

/* Initialize Kernel */

require ZEELIB.'/Kernel.class.php';

spl_autoload_register('\Zee\Kernel::AutoLoad');
set_error_handler('\Zee\Kernel::Halt');
set_exception_handler('\Zee\Kernel::Halt');
register_shutdown_function('\Zee\Kernel::SendBuffer');

/* Configurations */

$GlobalConfigurations = array();

foreach ( glob(CONFIG_DIR.'/*.json') as $file )
{
	if ( !is_readable($file) )
		throw new Exception('Configuration file '.$file.' is not readable.');

	$Object = json_decode(file_get_contents($file));

	if ( is_null($Object) )
		throw new Exception('Configuration file '.$file.' is not a valid JSON string.');

	$ConfigName = pathinfo($file)['filename'];

	$GlobalConfigurations[$ConfigName] = new \Zee\Config($Object, $file);
}

function Config($config)
{
	global $GlobalConfigurations;

	if ( !isset($GlobalConfigurations[$config]) )
		throw new Exception('No such configuration '.$config);

	return $GlobalConfigurations[$config];
}

/* Sessions */

session_start();

/* Globalization */

$_P = $_POST;
$_G = $_GET;
$_R = $_REQUEST;
$_S = $_SESSION;