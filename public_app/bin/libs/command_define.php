<?php

//基底ディレクトリ設定
if( !defined( 'BASE_DIR' ) ) {
    define( 'BASE_DIR',
        realpath( dirname( dirname( dirname( __FILE__ ) ) ) ).'/' );
}

define( 'CMD_DIR', realpath( dirname( dirname( __FILE__ ) ) ). '/' );

//ディレクトリ設定
if( !defined( 'LOG_DIR' ) ) define( 'LOG_DIR', BASE_DIR.'log/' );
if( !defined( 'LIB_DIR' ) ) define( 'LIB_DIR', BASE_DIR.'lib/' );
if( !defined( 'SKL_DIR' ) ) define( 'SKL_DIR', BASE_DIR.'skl/' );
if( !defined( 'TMP_DIR' ) ) define( 'TMP_DIR', BASE_DIR.'tmp/' );
if( !defined( 'MOD_DIR' ) ) define( 'MOD_DIR', BASE_DIR.'mod/' );
if( !defined( 'SAS_DIR' ) ) define( 'SAS_DIR', BASE_DIR.'sas/' );
if( !defined( 'HTML_DIR' ) ) define( 'HTML_DIR', BASE_DIR.'html/' );
if( !defined( 'PKG_DIR' ) ) define( 'PKG_DIR', MOD_DIR.'pkg/' );

if( !defined( 'SAS_BAS_DIR' ) ) define( 'SAS_BAS_DIR', SAS_DIR.'basics/' );
if( !defined( 'MOD_COM_DIR' ) ) define( 'MOD_COM_DIR', MOD_DIR.'common/' );
if( !defined( 'SIMPLAN_CLASS_DIR' ) ) {
    define( 'SIMPLAN_CLASS_DIR', LIB_DIR.'Simplan/class/' );
}

include_once( 'cSmarty.php' );
include_once( SIMPLAN_CLASS_DIR.'DB/Sas.php' );
include_once( SIMPLAN_CLASS_DIR.'SimplanIniReader.php' );
?>
