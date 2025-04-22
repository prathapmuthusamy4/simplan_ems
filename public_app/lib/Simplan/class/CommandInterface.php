<?php
//******************************************************************************
// 機能名   ： コマンドインターフェースクラス
//              コマンドを呼び出す
// 作成日   ： 2005.04.19
//******************************************************************************
class CommandInterface {

    //*** 変数宣言 ***//
    var $logger;
    var $connection;

    //******************************************************************************
    // 関数名   ：  CommandInterface
    // 機能名   ：  コンストラクタ
    // 引　数   ：  $logger     (SystemLog)システムロガー
    //              $cnct       (Connection)データベースコネクション
    // 戻り値   ： なし
    //******************************************************************************
    function CommandInterface($logger, &$connection)
    {
        $this->logger = $logger;
        $this->connection = $connection;
    }

    //**************************************************************************
    // 関数名   ：  executeCommand
    // 機能名   ：  コマンド実行メソッド
    // 引　数   ：  $cmd        (String)コマンドキー
    //              $input      (Hashmap)コマンド実行時引数
    // 戻り値   ：  $rslt       (CommandMessage)コマンド実行結果
    // 備　考   ：  
    //**************************************************************************
    function executeCommand($mod, $cmd, $cmdMsg) {

        //*** 指定コマンドの取得 ***//
        $name = $cmd;
        //*** 指定コマンドファイルチェック ***//
        $path = SAS_COMMAND_DIR . "/{$mod}/{$cmd}.php";
        if (!file_exists($path)) {
            //*** ERRORレベルログの出力 ***//
            $this->logger->error("CommandInterface::executeCommand > command file not found [ {$name} ]");
            trigger_error ("CommandInterface::executeCommand > command file not found [ {$name} ]", E_USER_ERROR);
        }

        //*** INFOレベルログの出力 ***//
        $this->logger->info("CommandInterface::executeCommand > [ {$name} ]");

        require_once($path);
        if (!class_exists($name)) {
            //*** ERRORレベルログの出力 ***//
            $this->logger->error("CommandInterface::executeCommand > class not found [ {$name} ]");
            trigger_error ("CommandInterface::executeCommand > class not found [ {$name} ]", E_USER_ERROR);
        }

        $command = new ${'name'}($this->logger, $this->connection);
        $result = $command->execute($cmdMsg);

        return $result;
    }

}
?>