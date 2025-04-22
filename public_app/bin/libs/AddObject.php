<?php
include_once( 'AddClass.php' );
if( !defined( 'SAS_MANA_DIR' ) ){
    define( 'SAS_MANA_DIR', realpath( BASE_DIR.'/sas/maneger' ).'/' );
}
if( !defined( 'SAS_BAS_DIR' ) ){
    define( 'SAS_BAS_DIR', realpath( BASE_DIR.'/sas/basics' ).'/' );
}
/**
 * データベースマップ作成コマンド
 *
 * @link       
 * @author   
 * @license 
 * @package Simplan
 * @version 1.0
 */
class   AddObject
{
    var $ObjPath;
    var $FacPath;
    var $Target;
    var $TempPath;
    var $CleanUpFlag;
    var $WriteFlag;

    function AddObject(){
        $this->ObjPath  = SAS_BAS_DIR ;
        $this->FacPath  = SAS_CLASS_DIR;
        $this->Target   = NULL;
        $this->TempPath   = BASE_DIR.'/skl/';
        $this->CleanUpFlag= false;
        $this->WriteFlag = false;
    }

    //引数処理
    function ArgProc( $argc, $argv, $offset ){
        Global $ini;
        Global $EchoFlag;

        if( is_null( $argv[ $offset + 1 ] ) ){
            MyExit( " simplan add-object <ModuleName | -a >", true);
        }

        if( $argv[ $offset + 1 ] == '-a' || $argv[ $offset + 1 ] == '-all' ) {
            $this->Target = '-all';
        } else {
            $this->Target = array( $argv[ $offset + 1 ] );
        }

        for( $n = $offset + 2; $n < $argc; $n ++ ){
            switch( $argv[$n] ){
                case '-s':  //サイレントモード
                    $EchoFlag = false;
                    break;

                case '-f':  //上書きモード
                    $this->WriteFlag = true;
                    break;

                default:    //引数エラー
                    MyExit(  "simplan add-process <ProcessName> "
                        ."<path> -ini <INI file>".
                        "   <path> is under <Simplan Root>/mod/",
                        true);
                    exit;
            }
        }

    }

    function Call(){
        Global $ini;
        $nowtime = getdate( time() );

        //DB内の全テーブルリストの取得
        $db = new WideDB_CommandInterface();
        $db->Connect();
        $res = $db->command->GetTableInfo();
        $res->RecResult( 2 );
        $tmp =  $res->GetResult();
        //リソースの解放
        $res->FreeResult();
        unset ( $res );
        MyEcho( "Get All Tables Name ..." );

        $table_node = $tmp['Name'];
        $table_comment = array();
        for($n = 0; $n < count($table_node); $n ++ ){
            $table_comment[$table_node[$n]] = $tmp['Comment'][$n];
        }
        unset( $tmp );

        //パラメータ整合性チェック
        if( $this->Target == '-all' ) {
            $this->Target = $table_node;
        } else {
            if( array_search( $this->Target[0], $table_node ) === false ){
                MyExit( $this->Target[0]." don't have Table.", true );
            }
        }
        MyEcho( "        OK" );

        MyEcho( " > Create TabledDefineClass files ..." );
        //定義情報クラスの生成
        // sas/basics 以下に定義ファイルを生成する
        $val = NULL;
        $res = NULL;
        foreach( $this->Target as $table ) {
            MyEcho( "          > $table" );
            $this->CreateTableDefineClass(
                        $db, $table, $table_comment[$table], $val );

            //sas/basics ディレクトリ作成
            if( !file_exists( SAS_BAS_DIR.$table ) ) {
                @mkdir( SAS_BAS_DIR.$table );
                MyEcho( 'mkdir '.SAS_BAS_DIR.$table  );
            }

            //sas/manager ディレクトリ作成
            if( !file_exists( SAS_MANA_DIR.$table ) ) {
                @mkdir( SAS_MANA_DIR.$table );
                MyEcho( 'mkdir '.SAS_MANA_DIR.$table  );
            }
        }

        //コマンドファイルの生成
        //$this->CreateBasicesCommandFiles();

        MyEcho( " > Create SQL files ..." );
        //SQLファイルの生成
        $this->CreateSQL();

        //データベース切断
        $db->DisConnect();
        MyEcho( ' > DB Disconnected' );
    }

    //sas/manager以下にsqlテンプレートを作成する
    function CreateSQL(){

        foreach( $this->Target as $table ){
            $thisname = AddClass::GetSasModName( $table );
            $cmd_list = array( 
                    "Delete"    => $table."_delete.sql",
                    "Insert"    => $table."_insert.sql",
                    "Update"    => $table."_update.sql",
                    "SelectOne" => $table."_selectone.sql",
                    "SelectAll" => $table."_selectall.sql",
                );
            MyEcho("          > $table");
            foreach( $cmd_list as $type => $name ){
                MyEcho( "               $type" );
                $sql        = '';
                $out_path   = SAS_MANA_DIR."{$table}/{$name}";
                //SQL生成
                //テンプレートファイルの選択
                switch( strtoupper( $type ) ){
                    case 'SELECTONE':
                        $sql = $this->SelectOneSQL( $table );
                        break;

                    case 'SELECTALL':
                        $sql = $this->SelectSQL( $table );
                        break;

                    case 'UPDATE':
                        $sql = $this->UpdateSQL( $table );
                        break;

                    case 'INSERT':
                        $sql = $this->InsertSQL( $table );
                        break;

                    case 'DELETE':
                        $sql = $this->DeleteSQL( $table );
                        break;
                }

                //置換出力 manager
                if( $this->WriteFlag ){
                    if( file_exists( $out_path ) ) {
                        MyEcho( "                 ! {$name} is over write.");
                    }
                    file_put_contents( $out_path, $sql );
                }
            }
        }
    }
    //--------------------------------------------------------------------------

    //{{{CreateBasicesCommandFiles()
    // sas/manager 以下に基本コマンドクラスを生成する
    //  <table>/<ModName>BasicsDelete.php
    //  <table>/<ModName>BasicsInsert.php
    //  <table>/<ModName>BasicsSelectOne.php
    //  <table>/<ModName>BasicsSelectAll.php
    //  <table>/<ModName>BasicsUpdate.php
    function CreateBasicesCommandFiles(){

        foreach( $this->Target as $table ){
            MyEcho( " > {$table} Create Manager" );

            $thisname = AddClass::GetSasModName( $table );
            $cmd_list = array( 
                    "Delete"    => $thisname."BasicsDelete",
                    "Insert"    => $thisname."BasicsInsert",
                    "Update"    => $thisname."BasicsUpdate",
                    "SelectOne" => $thisname."BasicsSelectOne",
                    "SelectAll" => $thisname."BasicsSelectAll",
                );

            foreach( $cmd_list as $type => $name ){

                $typename   = ucfirst( strtolower( $type ) );
                $in_path    = '';
                $man_in  = SKL_DIR.'skel.sas.manager.tbl.TblAction.php';
                $man_out    = SAS_MANA_DIR."$table/{$thisname}{$typename}.php";
                $out_path   = SAS_BAS_DIR."$table/{$name}.php";
                $sql = '';

                $args   = array(
                        '{$year}'       => $nowtime['year'],
                        '{$month}'      => $nowtime['mon'],
                        '{$day}'        => $nowtime['wday'] + 1,
                        '{$CommandType}'=> $type,
                        '{$CommandName}'=> $name,
                        '{$TableName}'  => $table,
                        '{$ThisName}'   => $thisname.$typename,
                        '{$ObjectName}' => $thisname.'Basics'.$typename,
                        '{$ObjectPath}' =>
                            "{$table}/{$thisname}Basics{$type}".'.php',
                );

                //SQL生成
                //テンプレートファイルの選択
                switch( strtoupper( $type ) ){
                    case 'SELECTONE':
                        $sql = $this->SelectOneSQL( $table );
                        $in_path = SKL_DIR.'skel.sas.basics.tbl.TblSelect.php';
                        break;

                    case 'SELECTALL':
                        $sql = $this->SelectSQL( $table );
                        $in_path = SKL_DIR.'skel.sas.basics.tbl.TblSelect.php';
                        break;

                    case 'UPDATE':
                        $sql = $this->UpdateSQL( $table );
                        $in_path = SKL_DIR.'skel.sas.basics.tbl.TblUpdate.php';
                        break;

                    case 'INSERT':
                        $sql = $this->InsertSQL( $table );
                        $in_path = SKL_DIR.'skel.sas.basics.tbl.TblInsert.php';
                        break;

                    case 'DELETE':
                        $sql = $this->DeleteSQL( $table );
                        $in_path = SKL_DIR.'skel.sas.basics.tbl.TblDelete.php';
                        break;
                }
                $args['{$Sql}'] = $sql;

                //置換出力 basics
                MyEcho( " ! {$out_path} is over write." );
                file_put_contents( $out_path,
                    ReplaceArray( file_get_contents( $in_path ), $args)
                );

                //置換出力 manager
                if( $this->WriteFlag ){
                    MyEcho( " ! {$man_out} is over write.");
                    file_put_contents( $man_out,
                        ReplaceArray( file_get_contents( $man_in ), $args)
                    );
                }
            }
        }
    }
    //--------------------------------------------------------------------------
    //}}}

    //{{{ CreateTableDefineClass( &$db, $table, $comment, $trg )
    function CreateTableDefineClass( &$db, $table, $comment, $trg ){
        $nowtime = getdate( time() );
        //テーブル毎のフィールド情報取得
        $resA = $db->command->GetFieldInfo( $table );

        //結果取得
        $resA->RecResult( 2 );
        $fields = $resA->GetResult();

        $thisname = AddClass::GetTablesName( $table );
        $obj_name = AddClass::GetTablesObjectName( $table );
        $dispname = $thisname.'BasicsObject.php';
        MyEcho( "                ".$dispname );

        //置換出力
        $ret = file_put_contents(
            SAS_BAS_DIR.$dispname,
            ReplaceArray(
                file_get_contents(
                    $this->TempPath.'skel.sas.basics.BasicsObject.php' ),
                array(
                    '{$var_1}'  => '1',
                    '{$var_2}'  => '1',
                    '{$var_3}'  => '1',
                    '{$c_year}' => $nowtime['year'],
                    '{$c_month}'=> $nowtime['mon'],
                    '{$c_day}'  => $nowtime['wday'] + 1,
                    '{$TableName}'  => $table,
                    '{$TableComment}'=>$comment,
                    '{$ObjectName}' => $thisname,

                    '{$Table_All_Fields}' =>
                        $this->TableAllFieldsString( $fields['Field'] ),

                    '{$Table_Field_Type}' =>
                        $this->TableFieldTypeString(
                            $fields['Field'], $fields['Type'] ),

                    '{$Table_Field_Size}' =>
                        $this->TableFieldSizeString(
                            $fields['Field'], $fields['Type'] ),

                    '{$Table_Field_Key}' =>
                        $this->TableFieldString(
                            $fields['Field'], $fields['Key'] ),

                    '{$Table_Field_Null}' =>
                        $this->TableFieldString(
                            $fields['Field'], $fields['Null'] ),

                    '{$Table_Field_Comment}' =>
                        $this->TableFieldString(
                            $fields['Field'], $fields['Comment'] ),
                )
            )
        );
    }
    //--------------------------------------------------------------------------
    //}}}

    function IncludeFilesString( $tables ){
        $str = '';
        foreach( $tables as $val ){
            $str .=
                "include_once SAS_AUTO_OBJ_DIR.'sas_TableDefine_$val.php';\n";
        }
        return $str;
    }
    //--------------------------------------------------------------------------

    function NewClassCaseString( $tables ){
        $str = '';
        foreach( $tables as $val ){
            $str .=
                 "          case '$val':\n"
                ."              return new SasTableDefine_$val;\n";
        }
        return $str;
    }
    //--------------------------------------------------------------------------

    function TableAllFieldsString( $fields ){
        $str = '';
        foreach( $fields as $val ){
            $str .= "                   '$val',\n";
        }
        return $str;
    }
    //--------------------------------------------------------------------------

    function TableFieldTypeString( $name, $fields ){
        $str = '';
        for( $n = 0; $n < count( $name ); $n ++ ){
            $key = $name[$n];
            $val = $fields[$n];

            $tmp = split( '\(', $val );
            $val = $tmp[0];
            $str .= "                   '$key' => '$val',\n";
        }
        return $str;
    }
    //--------------------------------------------------------------------------

    function TableFieldSizeString( $name, $fields ){
        $str = '';
        for( $n = 0; $n < count( $name ); $n ++ ){
            $key = $name[$n];
            $val = $fields[$n];
            if( strpos( $val, '(' ) !== false ){
                $tmp = explode( '(', $val );
                $tmp = explode( ')', $tmp[1] );
                $val = $tmp[0];
            }
            $str .= "                   '$key' => '$val',\n";
        }
        return $str;
    }
    //--------------------------------------------------------------------------

    function TableFieldString( $name, $fields ){
        $str = '';
        for( $n = 0; $n < count( $name ); $n ++ ){
            $key = $name[$n];
            $val = $fields[$n];
            $str .= "                   '$key' => '$val',\n";
        }
        return $str;
    }
    //--------------------------------------------------------------------------

    function SelectSQL( $table ){
        $obj = SasFactor::CreateSelect( $table );
        return SasAutoSQL::Build( $obj );
    }
    //--------------------------------------------------------------------------

    function SelectOneSQL( $table ){
        $obj = SasFactor::CreateSelect( $table );
        $obj->MakeOneWhere('<?>');
        return SasAutoSQL::Build( $obj );
    }
    //--------------------------------------------------------------------------

    function UpdateSQL( $table ){
        $obj = SasFactor::CreateUpdate( $table );
        $obj->value->SetField_ReplaceKey( '<?>' );
        return SasAutoSQL::Build( $obj );
    }
    //--------------------------------------------------------------------------

    function InsertSQL( $table ){
        if( !($obj = SasFactor::CreateInsert( $table ) ) ) {
            var_dump( $obj );
        }
        $obj->value->SetField_ReplaceKey( '<?>' );
        $ret = SasAutoSQL::Build( $obj );
        return $ret;
    }
    //--------------------------------------------------------------------------

    function DeleteSQL( $table ){
        $obj = SasFactor::CreateDelete( $table );
        return SasAutoSQL::Build( $obj );
    }
    //--------------------------------------------------------------------------

}
//------------------------------------------------------------------------------

?>
