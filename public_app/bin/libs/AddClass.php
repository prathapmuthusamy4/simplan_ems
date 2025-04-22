<?php
include_once( 'command_define.php' );
/**
 * AddClassコマンド基本クラス
 */
class AddClass{
	//{{{ パラメータ
	var $ModPath;
	var $Target;
	var $InstallINI;
	var $InstallPath;
	var $ini;
	var $data;
	var $table;
	var $smt;
	// }}}

	//{{{ AddClass()
	function AddClass(){
	    $this->Target = NULL;
	    $this->InstallINI = dirname(dirname(__FILE__)).'/ini/process.ini';
	    $this->InstallPath = '';
		$this->ini =  NULL;
		$this->data = array();
		$this->smt	= new cSmarty();
		$this->table = NULL;
	}
	//}}}

	//{{{ ArgProc( argc, argv, offset) 引数の処理
	function ArgProc( $argc, $argv, $offset){
	    Global $EchoFlag;

	    $this->Target = $argv[$offset + 1 ];
		$this->data['cmd']['target'] = $this->Target;
	    //$this->InstallPath = $argv[ $offset + 2 ];

	    if( is_null( $this->Target ) ) {
			MyExit( "simplan add-process <ProcessName> ", true);
	    }

	    for( $n = $offset + 2; $n < $argc; $n ++ ){
	        switch( $argv[$n] ){
	            case '-ini': //設定ファイル指定
	                $this->InstallINI = $argv[++$n];
	                break;

	            case '-s':  //サイレントモード
	                $EchoFlag = false;
	                break;

				default:	//引数エラー
					MyExit( "simplan add-process <ProcessName> ".
						"-ini <INI file:Default ./ini/process.ini>\n", true);
					exit;
	        }
	    }

	    //引数エラーチェック
	    //Iniファイルの指定が無かった
	    if( is_null( $this->InstallINI ) ){
			MyExit( "simplan add-process <ProcessName> ", true );
	    }
		$this->smt->assign( 'cmd', $this->data['cmd'] );
	}
	//}}}

	//{{{ GetProcessConfig() プロセス設定の読込
	function GetProcessConfig(){
		$ini = basename( $this->InstallINI );
		if( !file_exists( $this->InstallINI ) ){
			MyExit( $ini.' does not exists.', true);
		}
		if( !($ret = parse_ini_file( $this->InstallINI, true )) ){
			MyExit( $ini.' is format error', true);
		}
		if( !array_key_exists( $this->Target, $ret ) ){
			MyExit( $ini.' does not have ['.$this->Target.'] Session', true);
		}
		$this->smt->assign( 'process', $this->data['process'][$this->Target] );
		return $ret;
	}
	//}}}

	// {{{ CreateTableObject( name ) Sasディレクトリのテーブルモデルを生成
	function CreateTablesObject( $name ){
		$tmp = explode( '_', $name );

		$trg = '';
		if( count( $tmp ) > 1 ) foreach( $tmp as $val ) $trg .= ucfirst($val);
		else $trg = $name;
		$trg .= 'BasicsObject';

		if( !file_exists( SAS_BAS_DIR.$trg.'.php' ) ){
			MyEcho( SAS_BAS_DIR.$trg.'.php' );
			MyExit( $trg.'.php is not exists in app/sas/basics.' );
		}
	   	require_once( SAS_BAS_DIR.$trg.'.php' );
		return new $trg();
	}
	//}}}

	//{{{GetTablesObjectName( $name )
	function GetTablesObjectName( $name ){
		$trg = AddClass::GetTablesName( $name );
		$trg .= 'BasicsObject';
		return $trg;
	}
	//}}}

	//{{{GetTablesName( $name )
	function GetTablesName( $name ){
		$tmp = explode( '_', $name );

		$trg = '';
		if( count( $tmp ) > 1 ) foreach( $tmp as $val ) $trg .= ucfirst($val);
		else $trg = $name;
		return $trg;
	}
	//}}}

	//{{{GetSasModName( $table ) 
    function GetSasModName( $table ) {
        if( preg_match( '(\_)', $table ) === false ){
            return ucfirst( $table );
        } else {
            $tmp = explode( '_', $table );
            $ret = '';
            foreach( $tmp as $val ) $ret .= ucfirst( $val );
            return $ret;
        }
    }
	//}}}
}
?>
