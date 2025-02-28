#!/usr/bin/php
<?php
include_once( './libs/command_define.php' );

#phpのパスの変更はインストールサーバ毎に必要

define( 'SAS_COMMAND_RUN', 1 );

//コントロールインクルード処理
/*
$controll_path = 'controll.php';
{
    if( !file_exists( $controll_path ) ) {
        $controll_path = '../'.$controll_path;
        if( !file_exists( $controll_path ) ) {
            echo 'Not Found controll.php';
            exit;
        }
    }
}
include_once $controll_path;
 */

$EchoFlag   = true;      //エコー出力フラグ
$DebugFlag  = true;      //デバグ用エコー出力フラグ
$ini        = NULL;
include_once BASE_DIR.'/bin/libs/com.php';
include_once BASE_DIR.'/bin/libs/AddObject.php';
include_once BASE_DIR.'/bin/libs/AddProcess.php';
include_once BASE_DIR.'/bin/libs/AddView.php';


################################################################################
# Main
################################################################################

    //グローバル変数
    $command_list = array();
    $ini = parse_ini_file( BASE_DIR.'/bin/ini/simplan.ini', true );

    ArgsProc();

    foreach( $command_list as $command ){
        $command->Call();
    }

################################################################################
Exit;
################################################################################

function ArgsProc(){
    Global  $argc;
    Global  $argv;
    Global  $command_list;

    if( $argc < 2 ) {
        MyEcho( "Not command." );
        MyExit( "simplan <command> <option>..." ,true);
    }

    //コマンド解析
    $num = 0;
    switch( $argv[1] ){
        case 'add-object':
           $command_list[$num] = new AddObject();
           $command_list[$num]->ArgProc( $argc, $argv, 1 );
           $num++;
           break;

       case 'add-process':
           $command_list[$num] = new AddProcess();
           $command_list[$num]->ArgProc( $argc, $argv, 1 );
           $num++;
           break;

       case 'add-view':
           $command_list[$num] = new AddView();
           $command_list[$num]->ArgProc( $argc, $argv, 1 );
           $num++;
           break;

       case 'add-app':
           $command_list[$num] = new AddObject();
           $command_list[$num]->ArgProc( $argc, $argv, 1 );
           $num++;
           $command_list[$num] = new AddProcess();
           $command_list[$num]->ArgProc( $argc, $argv, 1 );
           $num++;
           break;

       default:
           MyExit( 'Command Err.Not found command '.$argv[1], true );
   }
}
//------------------------------------------------------------------------------

?>
