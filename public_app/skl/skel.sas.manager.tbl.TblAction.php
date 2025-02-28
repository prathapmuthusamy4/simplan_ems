<?php
//******************************************************************************
// 機能名   ： 
// 作成日   ： {$year}.{$month}.{$day}
//******************************************************************************

include_once SAS_BAS_DIR.'{$ObjectPath}';

class {$ThisName} extends {$ObjectName} {

    function {$ThisName}( &$logger, &$sdb ){
        parent::{$ObjectName}( $logger, $sdb );
    }

    //**************************************************************************
    // 関数名   ：  execute
    // 機能名   ：  コマンド実行メソッド
    // 引　数   ：  $cmdMsg  (CommandMessage)コマンド実行パラメータ
    // 戻り値   ：  なし
    //**************************************************************************
    function execute ($cmdMsg) {

        // コマンド結果を生成
        $cmdRes = new CommandMessage();

        //*** 入力データの取得 ***//
        $input = $cmdMsg->getParameter();

        // SQL文の取得
        $sqlStr = parent::getSql();

        /*** 条件設定 **/
        // parent::setSqlParam( <Number>, '<変数>' );

        // SQLの実行
        $res = parent::executeSql( $sqlStr );

        // 結果の取得
        if ($res === false ) {
            /*** エラーメッセージを記述してください ***/
            $cmdRes->setErrMsg('クエリに失敗しました。');
        }

        $cmdRes->setParameter( $res );
        return $cmdRes;
    }
    //--------------------------------------------------------------------------

}
?>
