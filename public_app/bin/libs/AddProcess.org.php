<?php

class AddProcess{
	var $ModPath;
	var $Target;
	var $InstallINI;
	var $InstallPath;
	var $ini;
	var $data;

	function AddProcess(){
	    $this->Target = NULL;
	    $this->InstallINI = dirname(dirname(__FILE__)).'/ini/process.ini';
	    $this->InstallPath = '';
		$this->ini =  NULL;
		$this->data = array();
	}
	//--------------------------------------------------------------------------

	//引数の処理
	function ArgProc( $argc, $argv, $offset){
	    Global $EchoFlag;

	    $this->Target = $argv[$offset + 1 ];
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

	}
	//--------------------------------------------------------------------------

	function Call(){
		$obj = NULL;
		$q	= new WideQuery();
		$sys	= array();
	    MyEcho( "=== INI File Checking ..." );
	    //INIファイルのチェック
	    if( file_exists( $this->InstallINI ) == false ){
	        MyExit( $this->InstallINI." does not exists.1", true );
	    }
		if( !$this->SettingConfig() ){
	        MyExit( $this->InstallINI." does not exists.2", true );
		}

	    if( is_null( $this->ini ) || $this->ini == false ){
	        MyExit( $this->InstallINI." Load err.", true );
	    }
		if( !array_key_exists($this->Target, $this->ini) ){
			MyExit(
				$this->InstallINI." not found [{$this->Target}]Session.",
			   	true
		   	);
		}
		$ini = $this->ini[$this->Target];
		$sys = $this->GetSysArray();
	    MyEcho( "... ok \n" );

		//DB使用する場合
		if( strlen( $ini['table'] ) > 0 ) {
	    	MyEcho( "=== Used DataBase ..." );
			//定義ファイルの生成
			$obj = SasFunction::GetSasModName( 
					$this->ini[ $this->Target ]['table'] ).'BasicsObject';
			if( !file_exists( SAS_BAS_DIR.$obj.'.php') ){
				MyExit( SAS_BAS_DIR.$obj.'.php is not found. Please make file.',
				true
				);
			}
	    	require_once( SAS_BAS_DIR.$obj.'.php' );
	    	$obj = new $obj();
			if( is_null($obj) ) MyEixt(SAS_BAS_DIR.$obj.'.php is not exists.');
		} else {
	    	MyEcho( "=== Not Used DataBase ..." );
		}

	    MyEcho( "=== Making Process Directory ..." );
	    //moduleディレクトリに指定のモジュールが存在しているかを確認する
	    if( file_exists( $this->InstallPath ) == true ){
	        MyEcho( "  ".$this->InstallPath  );
	    }
	    $this->CreateInstallDirectory( $this->InstallPath );
	    MyEcho( "... ok \n" );
/*
	    //トリガファイルの設置
	    MyEcho( "=== Making Tringer File  ..." );
	    Global $ini;
	    $www_dir = $this->parse_directory( $this->GetWWW() );
	    DebugEcho( "Tringer: www/{$this->InstallPath}.php" );
		$q->Load( SKL_DIR.'skel.pg_name.php' );
		$q->Build( array_merge(
					$sys,
					array( 'ModName' => $this->InstallPath.'/',)
				)
			); 
		if( @file_put_contents(
				"{$www_dir}/{$this->InstallPath}.php",
				$q->GetSQL()
			) === false 
		){
			MyExit( "{$www_dir}/{$this->InstallPath}.php can't write.", true );
		}

	    MyEcho( "... ok \n" );
 */
	    //プロセスファイルの設置
	    MyEcho( "=== Making Process File  ..." );
		$path = "";
	    $this->CreateProcessFile( $this->InstallPath, $obj );
	    MyEcho( "... ok \n" );

	    //テンプレートファイルの設置
	    MyEcho( "=== Making Template File  ..." );
		$html_path = BASE_DIR.'/html/'.$this->InstallPath."/";
	    $this->CreateTemplateFile( $html_path, $obj );
	    MyEcho( "... ok \n" );

	    MyEcho( "Thank's." );
	}
	//--------------------------------------------------------------------------
	
	function SettingConfig(){
		if( ($this->ini = parse_ini_file($this->InstallINI, true) ) == false ) {
			print_r( $this->ini );
			return false;
		}
		if( !array_key_exists( $this->Target, $this->ini ) ){
			MyExit( "Not exists [{$this->Target}] Session." );
		}
		$trg = $this->Target;
		SetArrayValue( 'mod_dir', $this->InstallPath, $this->ini[$trg] );
		return true;
	}
	//--------------------------------------------------------------------------

	function GetSysArray(){
		$ret = array(
				'version'	=> '',
				'www_dir'	=> '',
			);
		$file = dirname(dirname(__FILE__)).'/ini/simplan.ini';
		$key = 'simplan_command_config';

		$tmpA = parse_ini_file( $file, true );
		if( $tmpA === false ) MyExit('app/bin/ini/simplan.ini not found',true);
		$tmpB = parse_ini_file( $this->InstallINI, true );
		if( $tmpB === false ) MyExit( $this->InstallINI.' not found',true);

		return array_merge( $ret, $tmpA[$key], $tmpB[$key] );
	}
	//--------------------------------------------------------------------------

	function GetWWW(){
		$key = 'simplan_command_config';
		if( array_key_exists( $key, $this->ini ) ){
			if( array_key_exists( 'www_dir', $this->ini[$key])){
				return $this->ini[$key]['www_dir'];
			}
		}
		MyEcho("www_dir is not exists in ".basename($this->InstallINI) );
		$file = dirname(dirname(__FILE__)).'/ini/simplan.ini';
		$tmp = parse_ini_file( $file, true );
		if( $tmp === false ) MyExit('app/bin/ini/simplan.ini not found',true);
		if( array_key_exists( $key, $tmp ) ){
			if(array_key_exists('www_dir',$tmp[$key]) ){
				return $tmp[$key]['www_dir'];
			}
		}
		MyExit('www_dir is not found.');
		exit;
	}
	//--------------------------------------------------------------------------

	//インストールディレクトリの作成
	function CreateInstallDirectory( $path ){
	    $tmp = MOD_DIR;

	    //mod以下ディレクトリの作成
	    foreach( split( '/', $path ) as $val ){
	        $tmp .= $val.'/';
	        if( file_exists( $tmp ) == false ){
	            DebugEcho( $tmp );
	            if( @mkdir( $tmp ) == false ){
	                MyEcho( $tmp." can't create directory." );
	                return false;
	            }
	        } else {
	            DebugEcho( $tmp." is exists." );
	        }
	    }

	    if( file_exists( $tmp.'process' ) == false ){ 
	        if( @mkdir( $tmp.'process' ) == false ){
	            MyExit( $tmp.'process'." can't create directoy", true );
	        }
	    }
/*
	    if( file_exists( $tmp.'view' ) == false ){ 
	        if( @mkdir( $tmp.'view' ) == false ){
	            MyExit( $tmp.'view'." can't create directoy", true );
	        }
	    }
 */
	    //公開ディレクトリの作成
	    $tmp = $this->parse_directory( $this->GetWWW().'/' );
		$di = split( '/', dirname($path) );
	    foreach( split( '/', $path ) as $val ){
	        $tmp .= $val.'/';
			$tmp = realpath( $tmp );
			echo $tmp."\n";
	        if( file_exists( $tmp ) == false ){
				if( $di[count($di)-1] == $val ) continue;
	            DebugEcho( $tmp );
	            if( @mkdir( $tmp ) == false ){
	                MyEcho( $tmp." can't create directory." );
	                return false;
	            }
	        } else {
	            DebugEcho( $tmp." is exists." );
	        }
	    }
	    return true;
	}
	//--------------------------------------------------------------------------

	//ファイルの置換、設置
	function CreateProcessFile( $path, $obj ){

	    //input.checkの作成
	    $this->MakeCheck( $obj, MOD_DIR.$path, 'input.check' );

	    //search.checkの作成
	    $this->MakeCheck( $obj, MOD_DIR.$path, 'search.check' );

		//プロセスプロパティファイルのコピー
		if( !copy( SKL_DIR.'skel.process.properties',
				   MOD_DIR.$path.'/process.properties' )
	   	) {
			MyExit( "process.properties Copy Done...", true );
		}

	    //プロセスファイルの生成
	    $event = array(
	        'skel.process.DelProcess.php' =>
	            $this->Target.'DelProcess.php',
	        'skel.process.EditProcess.php' =>
	            $this->Target.'EditProcess.php',
	        'skel.process.ListProcess.php' =>
	            $this->Target.'ListProcess.php',
	        'skel.process.NewProcess.php' =>
	            $this->Target.'NewProcess.php',
	        'skel.process.IndexProcess.php' =>
	            $this->Target.'indexProcess.php',
			'skel.process.common.php'		=>
				$this->Target.'_common.php'
	    );

	    //置換文字列の生成
		$tmp = $this->ini[$this->Target];
	    $args = array(
	        'APP_NAME'		=> $tmp['APP_NAME'],
	        'pg_name'		=> $this->Target,
	        'table_name'	=> $tmp['table'],
	        'SessionName' 	=> AddProcess::GetSesName( $path ),
			'ParentProcess'	=> $tmp['mod_type'].'Process',

	        'Table_All_Field' =>
	            $this->ArrayNodeString( $obj->field_name ),

	        'Table_Primary_Field' =>
	            $this->ArrayNodePrimaryString(
	                $obj->field_name, $obj->field_type_key),

	        'Param_Primary_Field' =>
	            $this->ParamPrimaryString(
	                $obj->field_name, $obj->field_type_key),

	        'SetParamFieldPrim' =>
	                $this->SetParamFieldPrimString(
	                    $obj->field_name, $obj->field_type_key ),

	        'GetDataParam' =>
	                $this->GetDataString(
	                    $obj->field_name, $obj->field_type_key ),
	    );

	    //ファイルの生成
		$q = new WideQuery();
		$q->SetTag( '{$', '}' );

		foreach( $event as $name => $val ){
			MyEcho( $name );
			$q->Load( SKL_DIR."{$name}" );
			$q->Build( $args );
			file_put_contents( MOD_DIR."{$path}/process/{$val}", $q->GetSQL() );
		}
		/*
	    foreach( $event as $name => $val ){
	        DebugEcho( "<< ".$name );
	        DebugEcho( ">> "."$path/process/$val" );
	        FileReplaceArray(
	            SKL_DIR."$name",
	            MOD_DIR."$path/process/$val",
	            $args
	        );
	    }
		 */
	}
	//--------------------------------------------------------------------------

	function CreateTemplateFile( $path, $obj ){
		DebugEcho( "CreateTemplateFile -------------\n" );
	    //テンプレートファイルのリスト
	    $event = array(
	        'skel.view.confirm.tpl' => 'confirm.tpl',
	        'skel.view.del_c.tpl'   => 'del_c.tpl',
	        'skel.view.del_e.tpl'   => 'del_e.tpl',
	        'skel.view.edit_c.tpl'  => 'edit_c.tpl',
	        'skel.view.edit_e.tpl'  => 'edit_e.tpl',
	        'skel.view.input.tpl'   => 'input.tpl',
	        'skel.view.list.tpl'    => 'list.tpl',
	        'skel.view.new.tpl'     => 'new.tpl',
	        'skel.view.new_c.tpl'   => 'new_c.tpl',
	        'skel.view.new_e.tpl'   => 'new_e.tpl',
	    );

		$tmp = '';
		foreach( explode( '/', $path ) as $node ){
			$tmp .= $node.'/';
			echo $tmp."\n";
			if( !file_exists( $tmp ) ){
				if( !@mkdir( $tmp ) ){
					MyExit(
						"CreateTemplateFile function \n".
						"\t{$tmp} can't create directory"
				   	);
				}
			}
		}
	    //置換文字列の生成
	    $args = array(
	        '{pg_name}' => $this->Target,
	        '{APP_NAME}' =>
	            $this->ini[$this->Target]['APP_NAME'],
	        'TABLE_FIELDS' =>
	            array( $this->GetTemplateArray(
	                $obj->field_name, $obj->field_comment )
	            ),
	    );

	//	$q = new WideQuery();
	    //ファイルの生成
	    foreach( $event as $name => $val ){
	        DebugEcho( "<< ".$name );
	/*
			if( !$q->Load( SKL_DIR.$name ) ){
				MyExit( SKL_DIR.$name." is not exists." );
			}
	*/
	//		$q->Build( $args );
	        DebugEcho( ">> "."$path/$val" );
		//	file_put_contents( "{$path}/{$val}", $q->GetSQL() );
	//		/*
	        FileReplaceAArray(
	            SKL_DIR."$name",
	            "$path/$val",
	            $args
	        );
	//		 */
	    }
	}
	//--------------------------------------------------------------------------

	function MakeCheck( &$obj, $path, $name ) {
	    $tmp = SKL_DIR.'skel.'.$name;
	    $str = file_get_contents( $tmp );

	    foreach( $obj->field_name as $val ){
	        //フィールド名
	        $str .= str_pad( $val, 28).'=';

	        //必須項目
	        if( strtoupper($obj->field_null[$val]) == 'YES' )
	            $str.= ' 1,';
	        else
	            $str.= ' 0,';

	        //種別
	        switch( strtoupper( $obj->field_type[$val]) ){
	            case 'VARCHAR':
	            case 'CHAR':
	            case 'TEXT':
	                $str .= str_pad( 'TEXT', 13, ' ', STR_PAD_LEFT ).',';
	                break;
	            default:
	                $str .= str_pad( strtoupper( $obj->field_type[$val] ),
	                                    13, ' ', STR_PAD_LEFT ).',';
	                break;
	        }

	        //最小値
	        $str .= str_pad( "0,", 13, ' ', STR_PAD_LEFT );

	        //最大値
	        $str .= str_pad( $obj->field_type_size[$val].',',
	                            16, ' ', STR_PAD_LEFT );

	        //Trimフラグ
	        $str .= str_pad( "1,", 13, ' ', STR_PAD_LEFT );

	        //タイトル
	        $str .= mb_str_pad( $obj->field_comment[$val],
	                             22, ' ', STR_PAD_LEFT );
	        //改行
	        $str .= ",\n";
	    }
	    file_put_contents( $path.'/'.$name, $str );
	}
	//--------------------------------------------------------------------------

	function ArrayNodeString( $node ){
	    $re = '';
	    $len = 0;
	    foreach( $node as  $val ){
	        $re .= "                ";
	        $re .= "'$val' => '',\n";
	    }
	    return $re;
	}
	//--------------------------------------------------------------------------

	function ArrayNodePrimaryString( $items, $prim ){
	    $re = '';

	    foreach( $items as $val ){
	        if( $prim[$val] != 'PRI' ) continue;
	        $re .= "                       ";
	        $re .= "'$val' => '',\n";
	    }
	    return $re;
	}
	//--------------------------------------------------------------------------

	function ParamPrimaryString( $items, $prim ){
	    $re = '';

	    $len = count( $items );
	    for( $n = 0; $n < $len; $n ++ ) {
	        if( $prim[$items[$n]] != 'PRI' ) continue;
	        $re .= '$param['."'".$items[$n]."']";
	        if( $n + 1 < $len && $n > 0) $re .= ", ";
	    }
	    return $re;
	}
	//--------------------------------------------------------------------------

	function GetSesName( $str ){
	    $tmp = split( '/', $str );
	    return strtoupper( implode( $tmp, '_' ) );
	}
	//--------------------------------------------------------------------------

	function SetParamFieldPrimString( $items, $prim ){
	    $re = '';
	    $len = count( $items );
	    for( $n = 0; $n < $len; $n ++ ) {
	        if( $prim[ $items[$n] ] != 'PRI' ) continue;
	        $re .= '       ';
	        $re .= '$setParam[\''.$items[$n].'\'] = '.
	            '$param[\''.$items[$n]."'];";
	        if( $n + 1 < $len && $n > 0) $re .= "\n";
	    }
	    return $re;
	}
	//--------------------------------------------------------------------------

	function GetDataString( $items, $prim ){
	    $re = '';
	    $len = count( $items );
	    for( $n = 0; $n < $len; $n ++ ) {
	        if( $prim[ $items[$n] ] != 'PRI' ) continue;
	        $re .= '        ';
	        $re .= '$setParam = array ( \''.$items[$n].'\' => $id ) ';
	        if( $n + 1 < $len && $n > 0) $re .= "\n";
	    }
	    return $re;
	}
	//--------------------------------------------------------------------------

	function GetTemplateArray( $items, $comment ){
	    $re = array();
	    $n = 0;
	    foreach( $items as $val ){
	        $re[$n++] = array(
	            '{$field_name}' => $val,
	            '{$field_comment}' => $comment[$val],
	        );
	    }
	    return $re;
	}
	//--------------------------------------------------------------------------

	function parse_directory( $str ){
		$path = dirname(dirname(dirname(__FILE__)));
		$tmp = explode( '/', $str );
		for( $n = 0; $n < count( $tmp ); $n ++ ){
			if( $n == 0 ){ if( $tmp[$n] != '..' ) return $str; }

			switch( $tmp[$n] ){
				case '..':
				   	$path = dirname( $path );
				   	break;
				case '.': break;
				default:
					$path .= '/'.$tmp[$n];
				   	break;
			}
		}
		return $path;
	}
	//--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
