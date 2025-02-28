<?php
include_once( dirname(dirname(__FILE__)).'/controll.php' );
$if = new AbstractCommand(
			new SystemLog,
			new WideDB_SimplanInterface( new SystemLog)
	   	);
print_r( $if->executeSql( $argv[1] ) );
?>
