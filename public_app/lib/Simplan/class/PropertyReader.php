<?php
//******************************************************************************
// 機能名   ： プロパティファイル読み込み処理
//              プロパティファイルを読み込む
// 作成日   ： 2005.04.18
//******************************************************************************
class PropertyReader {
    //*** 変数定義 ***//
    var $props;             // プロパティデータ(Hashmap)

    //******************************************************************************
    // 関数名   ： PropertyReader
    // 機能名   ： コンストラクタ
    // 引　数   ： $prop_file   プロパティファイル名
    // 戻り値   ： プロパティデータ
    //******************************************************************************
    function PropertyReader ($prop_file) {
        $this->props = parse_ini_file( $prop_file );
        //$this->parse($prop_file);
    }

    //******************************************************************************
    // 関数名   ： parse
    // 機能名   ： プロパティファイル解析メソッド
    // 引　数   ： $prop_file   (String)プロパティファイル名
    // 戻り値   ： なし
    //******************************************************************************
    function parse ($prop_file) {

        // ファイル有無チェック
        if (file_exists($prop_file)) {
            // プロパティファイルの読み込み
            if ($fp = fopen($prop_file, 'r')) {
                while (!feof($fp)) {
                    $buf = "";
                    $lineData = fgets($fp, 4096);
                    // コメント行判定
                    if (strpos($lineData, '//') === 0) {
                        continue;
                    }
                    // '='のない行は無視
                    $pos = strpos($lineData , '=');
                    if (!$pos) {
                        continue;
                    } else {
                        // プロパティ名を取得・判定
                        $n = trim(substr($lineData, 0, $pos - 1));
                        // 値を取得
                        $buf = trim(substr($lineData, $pos + 1));
                        // コメント削除
                        $pos = strpos($buf, '//');
                        if ($pos) {
                            $buf = trim(substr($buf, 0, $pos - 1));
                        }
                        while (strpos($lineData, '\\') !== false && !feof($fp)) {
                            $lineData = fgets($fp, 4096);
                            // コメント削除
                            $pos = strpos($lineData, '//');
                            if ($pos) {
                                $buf .= trim(substr($lineData, 0, $pos - 1));
                            } else {
                                $buf .= trim($lineData);
                            }
                        }
                        $buf = str_replace("\t", "", $buf);
                        $buf = ltrim($buf);
                        $buf = rtrim($buf);
                        $this->props[$n] = str_replace("\\", "", $buf);
                    }
                }
                fclose($fp);
            }
        } else {
            // エラー処理
        }
    }

    //******************************************************************************
    // 関数名   ： getProperties
    // 機能名   ： 全プロパティGetter
    // 引　数   ： なし
    // 戻り値   ： $props       プロパティデータ
    //******************************************************************************
    function getProperties () {
        return $this->props;
    }

    //******************************************************************************
    // 関数名   ： getProperty
    // 機能名   ： プロパティGetter
    // 引　数   ： $key         (String)プロパティ名
    // 戻り値   ： $props[$key] プロパティデータ
    //******************************************************************************
    function getProperty ($key) {
        return $this->props[$key];
    }
}
?>