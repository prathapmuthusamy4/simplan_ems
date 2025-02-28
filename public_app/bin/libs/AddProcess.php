<?php
include_once( 'AddClass.php' );

class Addprocess extends AddClass{

	//{{{ AddProcess()
	function AddProcess(){
		parent::AddClass();
	}
	//}}}

	// {{{ Call() 
	function Call(){
		//プロセス設定の読込
		$this->data['process'] = $this->GetProcessConfig();

		//DB使用する場合
		$ini =& $this->data['process'][$this->Target];
		if( strlen( $ini['table'] ) > 0 ) {
	    	MyEcho( "=== Used DataBase ..." );
			//定義ファイルの生成
			$this->table = $this->CreateTablesObject( $ini['table'] );
		} else {
	    	MyEcho( "=== Not Used DataBase ..." );
		}

		//ディレクトリの生成
		$this->CreateProcessDirectory();

		//プロセス設定ファイルの生成
		$this->CreateProcessConfigFiles();

		//プロセスファイルの生成
		$this->CreateProcessFiles();
	}
	//}}}

	//{{{ CreateProcessDirectory() プロセスディレクトリの生成
	function CreateProcessDirectory(){
		$conf =& $this->data['process'][$this->Target];
		if( !file_exists( MOD_DIR ) ) MyExit( 'app/mod is not exists' );
		$base = realpath( MOD_DIR.'/'.$conf['group'] );
		MyEcho( "mkdir ".$base );
		if( !file_exists( $base ) ){
			if( !@mkdir( $base ) ) MyExit( $base.' does not mkdir.' );
		}
		$base = realpath( $base).'/'.$this->Target;
		MyEcho( "mkdir ".$base );
		if( !file_exists( $base ) ){
			if( !@mkdir( $base ) ) MyExit( $base.' does not mkdir.' );
		}
		$this->data['dir']['process_base'] = $base;
		$base .= '/process';
		MyEcho( "mkdir ".$base );
		// process ディレクトリの生成
		if( !file_exists( $base ) ){
			if( !@mkdir( $base ) ) MyExit( $base.' does not mkdir.' );
		}
		$this->data['dir']['process'] = $base;
	}
	// }}}

	// {{{ CreateProcessConfigFiles() プロセス設定ファイルの生成
	function CreateProcessConfigFiles() {
		$conf =& $this->data['process'][$this->Target];
		// process.properties
		{
			$param = array();
			$cnt = 0;
			foreach( explode( '|', $conf['MakeProcess'] ) as $val ){
			   	$param[$cnt]['process_name'] = $val;
				$param[$cnt]['process_type'] = strtolower( $val );
				$param[$cnt]['process_Label']= ucfirst( strtolower( $val ) );
				$this->data['process_files'][$cnt]['name'] =
				   	$this->Target.$param[$cnt]['process_Label'].'Process.php';
				$this->data['process_files'][$cnt]['type'] = strtolower($val);
				$cnt ++;
			}
			$this->smt->assign( 'process_list', $param );
			//echo $this->smt->fetch( 'skel.process.properties' );
			$this->smt->putFile(
				$this->data['dir']['process_base'].'/process.properties',
				'skel.process.properties'
		   	);
		}
		if( ( $cnt = count( $this->data['process_files'] ) ) > 0 ){
			$this->data['process_files'][$cnt]['name'] =
			   	$this->Target.'_common.php';
			$this->data['process_files'][$cnt]['type'] = 'common';
		}

		// input.check
		$param = array();
		$cnt = 0;
		$table =& $this->table;
		if( $table != null ) {
			foreach( $table->field_name as $val ){
				$param[$cnt]['name']	= $val;
				$param[$cnt]['required']=
				   	(($table->field_null[$val] == 'YES') ? 1 : 0 );
				switch( strtolower($table->field_typ[$val]) ){
					case 'varchar':
					case 'char':
					case 'text':
						$param[$cnt]['type'] = 'TEXT';
					   	break;
					default:
						$param[$cnt]['type'] = 'INT';
						break;
				}
				$param[$cnt]['min']		= 0;
				$param[$cnt]['max']		= $table->field_type_size[$val];
				$param[$cnt]['label']	= $table->field_comment[$val];
				$cnt ++;
			}
		}
		$this->smt->assign( 'colum_list', $param );
		$this->smt->putFile(
			$this->data['dir']['process_base'].'/input.check',
			'skel.input.check'
	   	);
		// search.check
		$this->smt->putFile(
			$this->data['dir']['process_base'].'/search.check',
			'skel.search.check'
	   	);
	}
	// }}}

	//{{{ CreateProcessFiles() プロセスファイルの生成
	function CreateProcessFiles(){
		$base = $this->data['dir']['process'];
		$ini =& $this->data['process'][$this->Target];
		$param = array(
				'pg_name'		=> $this->Target,
				'APP_NAME'		=> $ini['APP_NAME'],
				'table_name'	=> $ini['table'],
				'PrimaryKey'	=> '',
				'Table_All_Field'	=> array(),
				'PrimaryField'		=> array(),
				'ParentProcess'		=> $ini['mod_type'].'Process',
				'SessionName'		=>
					strtoupper( $ini['mod_type'].'_'.$this->Target ),
			);
		// Table_All_Field
		for( $n = 0; $n < count( $this->table->field_name ); $n ++ ){
			$param['Table_All_Field'][$n] = "'{$this->table->field_name[$n]}'";
		}
		// Primary Filed
		{
			$cnt = 0;
			foreach( $this->table->field_type_key as $key => $val ){
				if( $val == 'PRI' ) {
					$param['PrimaryField'][$cnt] = "'{$key}'";
					$cnt ++;
				}
			}
		}
		$this->smt->left_delimiter = '<!--{';
		$this->smt->right_delimiter = '}-->';
		$this->smt->assign( $param );

		foreach( $this->data['process_files'] as $val ){
			$type = '';
			$src = 'skel.process.';
			switch( strtolower($val['type']) ){
				case 'index':
					$type = 'Index';
					$src .= $type.'Process.php';
					break;
				case 'edit'	:
					$type = 'Edit';
					$src .= $type.'Process.php';
					break;
				case 'delete':
					$type = 'Del';
					$src .= $type.'Process.php';
					break;
				case 'list'	:
					$type = 'List';
					$src .= $type.'Process.php';
					break;
				case 'new'	:
					$type = 'New';
					$src .= $type.'Process.php';
					break;
				case 'detail':
					$type = 'Index';
					$src .= $type.'Process.php';
					break;
				case 'display':
					$type = 'Index';
					$src .= $type.'Process.php';
					break;
				case 'common':
					$type = 'common';
					$src .= $type.'.php';
				   	break;
			}

			$this->smt->putFile(
					$base.'/'.$val['name'],
					$src
				);
		}
	}
	//}}}

}
?>
