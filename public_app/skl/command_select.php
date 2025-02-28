<?php
//******************************************************************************
// 機能名   ： 
// 作成日   ： {$year}.{$month}.{$day}
//******************************************************************************
class {$CommandName} extends AbstractCommand {
    var $command_type;  //自動処理変数

    /*** コンストラクタは変更しないでください ***/
    function {$CommandName}(&$logger, &$sdb ){
        parent::AbstractCommand( $logger, $sdb );
        $this->command_type = '{$CommandType}';
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
        $sqlStr = $this->getSql();

        /*** 条件設定 **/
        //parent::setSqlParam(1, <値>) );

        // SQLの実行
        $res = parent::executeSql( $sqlStr );

        // 結果の取得
        $list = array();
        if ($rsltSet == false ) {
            /*** エラーメッセージを記述してください ***/
            $cmdRes->setErrMsg('クエリに失敗しました。');
        }

        $cmdRes->setParameter($res);
        return $cmdRes;
    }
    //--------------------------------------------------------------------------

    function getSql( $name ){
        return "{$Sql}";
    }
    //--------------------------------------------------------------------------
}
?>
