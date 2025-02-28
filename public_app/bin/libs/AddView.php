<?php
include_once( 'AddClass.php' );

class AddView extends AddClass{

	//{{{ AddProcess()
	function AddProcess(){
		parent::AddClass();
	}
	//}}}


	// {{{ Call() 
	function Call(){
		//プロセス設定の読込
		$this->data['process'] = parent::GetProcessConfig();

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
		$this->CreateViewDirectory();

		//プロセスファイルの生成
		$this->CreateViewFiles();
	}
	//}}}

	//{{{ CreateViewDirectory() プロセスディレクトリの生成
	function CreateViewDirectory(){
		$conf =& $this->data['process'][$this->Target];
		if( !file_exists( HTML_DIR ) ) MyExit( 'app/html is not exists' );
		$base = realpath(HTML_DIR).'/'.$conf['group'];
		MyEcho( "mkdir ".$base );
		if( !file_exists( $base ) ){
			if( !@mkdir( $base ) ) MyExit( $base.' does not mkdir.' );
		}
		$base = realpath( $base).'/'.$this->Target;
		MyEcho( "mkdir ".$base );
		if( !file_exists( $base ) ){
			if( !@mkdir( $base ) ) MyExit( $base.' does not mkdir.' );
		}
		$this->data['dir']['html'] = $base;
	}
	// }}}

	//{{{ CreateViewFiles() プロセスファイルの生成
	function CreateViewFiles(){
		$base = $this->data['dir']['html'];
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
		$this->data['view_files'] = array(
				'confirm.tpl',
				'input.tpl',
				'del_c.tpl',
				'del_e.tpl',
				'edit_e.tpl',
				'edit_c.tpl',
				'new.tpl',
				'new_e.tpl',
				'new_c.tpl',
				'list.tpl',
			);
		// Table_All_Field
		{
			$n = 0;
			foreach( $this->table->field_comment as $key => $val ){
				$param['Table_All_Field'][$n]['id']		= $key;
				$param['Table_All_Field'][$n]['name']	= $val;
				$n ++;
			}
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

		foreach( $this->data['view_files'] as $val ){
			$src = 'skel.view.'.$val;
			$this->smt->putFile(
					$base.'/'.$val,
					$src
				);
		}
	}
	//}}}

}
?>
