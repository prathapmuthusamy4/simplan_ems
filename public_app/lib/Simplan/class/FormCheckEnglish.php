<?php
//******************************************************************************
// 機能名   ： 入力データチェック汎用クラス
// 作成日   ： 2005.04.20
//******************************************************************************
class FormCheckEnglish {

    //*** 変数宣言 ***//
    var $reader;

    //******************************************************************************
    // 関数名   ：  FormCheckEnglish
    // 機能名   ：  コンストラクタ
    // 引　数   ：  $file       (String)プロパティファイル名
    // 戻り値   ：  プロパティデータ
    //******************************************************************************
    function FormCheckEnglish ($file) {
        //*** SQLファイルキーよりSQL定義ファイルを取得 ***//
        $file_name = PKG . $file;

        if (!file_exists($file_name)) {
            //*** ERRORレベルログの出力 ***//
            $this->logger->error("FormCheckEnglish::FormCheckEnglish > check file not found [ {$file_name} ]");
            trigger_error ("FormCheckEnglish::FormCheckEnglish > check file not found [ {$file_name} ]", E_USER_ERROR);
        }
        $this->reader = new SimplanIniReader($file_name, false);
    }

    //******************************************************************************
    // 関数名   ：  check
    // 機能名   ：  入力チェック
    // 引　数   ：  $input      (hashMap)入力データ
    // 戻り値   ：  なし
    //******************************************************************************
    function check (&$input)
    {
        //*** 入力チェック対象プロパティを取得 ***//
        $chk = $this->reader->getIni();

        $errList = array();
        //*** チェック項目についてチェック ***//
        foreach ($chk as $column => $v) {
            //*** 空白があると正常に動作しないため除去します ***//
            $v = str_replace (" ","", $v);

            list($must, $type, $min, $max, $trim, $name) = explode(",", $v);

            $data = mb_convert_encoding($input[$column], "EUC-JP", "UTF-8,EUC-JP");
            // Trim処理
            if ($trim === '1') {
                $data = ltrim($data);
            }

            // 必須入力チェック
            if ($must === '1' && $data === '') {
                if ($type === 'SELECT') {
                    $errList["{$column}"] = "Please Select {$name}.";
                } else {
                    $errList["{$column}"] = "Please Enter {$name}.";
                }
                continue;
            }

            // 形式チェック
            if ($must === '0' && $data === '') {
                continue;
            }

            // 形式チェック
            $errMsg = '';

            if ($type === 'TEXT') {                         // テキスト
                $errMsg = $this->isText($data, $min, $max, $name);
            } else if ($type === 'ALPHA') {                 // 半角英字
                $errMsg = $this->isAlpha($data, $min, $max, $name);
            } else if ($type === 'ALPHA_L') {               // 半角英字(大文字)
                $errMsg = $this->isAlphaLarge($data, $min, $max, $name);
            } else if ($type === 'ALPHA_S') {               // 半角英字(小文字)
                $errMsg = $this->isAlphaSmall($data, $min, $max, $name);
            } else if ($type === 'ALPHA_NUM') {             // 半角英数字
                $errMsg = $this->isAlphaNum($data, $min, $max, $name);
            } else if ($type === 'ALPHA_NUM_EX') {          // 半角英数字 + '-' + '.'
                $errMsg = $this->isAlphaNumEx($data, $min, $max, $name);
            } else if ($type == 'NUMBER') {                 // 数字
                $errMsg = $this->isNumber($data, $min, $max, $name);
            } else if ($type == 'NUMERIC') {                // 数値
                $errMsg = $this->isNumeric($data, $min, $max, $name);
            } else if ($type == 'DATE') {                   // 日付
                $errMsg = $this->isDate($data, $min, $max, $name);
            } else if ($type == 'DATETIME') {               // 日付時刻
                $errMsg = $this->isDateTime($data, $min, $max, $name);
            } else if ($type == 'TIME') {                   // 時刻
                $errMsg = $this->isTime($data, $min, $max, $name);
            } else if ($type == 'TEL') {                    // 電話番号
                $errMsg = $this->isTel($data, $min, $max, $name);
            } else if ($type == 'ZIP') {                    // 郵便番号
                $errMsg = $this->isZip($data, $min, $max, $name);
            } else if ($type == 'MAIL') {                   // メールアドレス
                $errMsg = $this->isMail($data, $min, $max, $name);
            } else if ($type == 'URL') {                    // URL
                $errMsg = $this->isUrl($data, $min, $max, $name);
            } else if ($type == 'HIRAGANA') {               // 全角ひらがな
                $errMsg = $this->isHiragana($data, $min, $max, $name);
            } else if ($type == 'KATAKANA') {               // 全角カタカナ
                $errMsg = $this->isKatakana($data, $min, $max, $name);
            } else if ($type == 'KATAKANA_EX') {            // 拡張カタカナ（英字含みあり）
                $errMsg = $this->isKatakanaEx($data, $min, $max, $name);
            } else if ($type === 'MOBILE_TEXT') {           // テキスト（モバイル用）
                $errMsg = $this->isMobileText($data, $min, $max, $name);
            }
            if (strlen($errMsg) > 0) {
                $errList["{$column}"] = $errMsg;
            }
        }
        return $errList;
    }

    //******************************************************************************
    // 関数名   ：  checkLength
    // 機能名   ：  文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    // 戻り値   ：  true：妥当／false：不当
    //******************************************************************************
    function checkLength ($data, $min, $max)
    {
        $rslt = true;

        if (!$this->checkLengthMin($data, $min)) {
            $rslt = false;
        }
        if (!$this->checkLengthMax($data, $max)) {
            $rslt = false;
        }
        return $rslt;
    }

    //******************************************************************************
    // 関数名   ：  checkLengthMin
    // 機能名   ：  最小文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    // 戻り値   ：  true：妥当／false：不当
    //******************************************************************************
    function checkLengthMin ($data, $min)
    {
        $rslt = true;
        if (strlen($data) < $min) {
            $rslt = false;
        }
        return $rslt;
    }

    //******************************************************************************
    // 関数名   ：  checkLengthMax
    // 機能名   ：  最大文字列長チェック
    // 引　数   ：  $data       (String)検証データ
    //              $max        (int)最大文字数
    // 戻り値   ：  true：妥当／false：不当
    //******************************************************************************
    function checkLengthMax ($data, $max) {
        $rslt = true;
        if (strlen($data) > $max) {
            $rslt = false;
        }
        return $rslt;
    }

    //******************************************************************************
    // 関数名   ：  isText
    // 機能名   ：  テキストチェック（半角カナが含まれている場合、エラーとする）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isText ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "The {$name} must be no more than {$min} characters long.";
                } else {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "The {$name} must be no more than {$max} characters long.";
            }
        }
        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            // 半角カタカナチェック
            if (preg_match("/(?:\x8E[\xA6-\xDF])/", $data)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isAlpha
    // 機能名   ：  半角英字チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isAlpha ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "The {$name} must be no more than {$min} characters long.";
                } else {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "The {$name} must be no more than {$max} characters long.";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[a-zA-Z]+$/", $data)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isAlphaLarge
    // 機能名   ：  半角英字（大文字）チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isAlphaLarge ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "The {$name} must be no more than {$min} characters long.";
                } else {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "The {$name} must be no more than {$max} characters long.";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[A-Z]+$/", $data)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isAlphaSmall
    // 機能名   ：  半角英字（小文字）チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isAlphaSmall ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "The {$name} must be no more than {$min} characters long.";
                } else {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "The {$name} must be no more than {$max} characters long.";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[a-z]+$/", $data)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isAlphaNum
    // 機能名   ：  半角英数チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isAlphaNum ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "The {$name} must be no more than {$min} characters long.";
                } else {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "The {$name} must be no more than {$max} characters long.";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^[a-zA-Z0-9]+$/", $data)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isAlphaNumEx
    // 機能名   ：  半角英数拡張チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isAlphaNumEx ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "The {$name} must be no more than {$min} characters long.";
                } else {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "The {$name} must be no more than {$max} characters long.";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([a-zA-Z0-9]|\\-|\\.)+$/", $data)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required. '.','-' is Ok";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isNumber
    // 機能名   ：  数字チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isNumber ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "The {$name} must be no more than {$min} characters long.";
                } else {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "The {$name} must be no more than {$max} characters long.";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^\d+$/", $data)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
            /*if (preg_match("/^0/", $data)) {
                $errMsg = "{$name}は正しい数字で入力してください。";
            }*/
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isNumeric
    // 機能名   ：  数値チェック（数字ではなく数値）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isNumeric ($data, $min, $max, $name) {
        $errMsg = '';
//print(preg_match("/^\d+$/", $data));
        // 先に形式チェック
        if (!preg_match("/^\d+$/", $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.";
        }
        if (! (($min == 0 && $max == 0) ||($min != "" && $max != "")) ) {
            if (strlen($errMsg) === 0) {
                if ($data < $min || $data > $max) {
                    $errMsg = "The {$name} must be at least {$min} and no more than {$max} characters in length.";
                }
            }
        }
        if ($max != 0 && $max != "") {
            if (strlen($errMsg) === 0) {
                if ($data > $max){
                    $errMsg = "The {$name} must be no more than {$max} characters long.";
                }
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isDate
    // 機能名   ：  日付チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isDate ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^[1-9][0-9][0-9][0-9]\/(1[0-2]|0[1-9])\/(3[01]|[12][0-9]|0[0-9])$/", $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.(YYYY/MM/DD)";
        } else {
            $date_ary = explode("/", $data);
            if (!checkdate(intval($date_ary[1]), intval($date_ary[2]), intval($date_ary[0]))) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isDateTime
    // 機能名   ：  日付時刻チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isDateTime ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^\d+$/", $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.";
        } else {
            if (strlen($data) != 12) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            } else {
                // 入力された日付をシリアル秒に変換
                $date_serial = mktime (substr($data, 8, 2), substr($data, 10, 2), 0, substr($data, 4, 2), substr($data, 6, 2), substr($data, 0, 4));
                // さらに日付形式に変換
                $comp = date('YmdHi', $date_serial);
                // 異なればエラー
                if ($data != $comp) {
                    $errMsg = "Please check the {$name}. A valid {$name} is required.";
                }
            }
        }
        return $errMsg;
    }


    //******************************************************************************
    // 関数名   ：  isTime
    // 機能名   ：  時刻チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小値
    //              $max        (int)最大値
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isTime ($data, $min, $max, $name) {
        $errMsg = '';

        // 先に数字チェック
        if (!preg_match("/^(2[0-3]|1[0-9]|0[0-9]):([0-5][0-9])$/", $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.(HH:MM)";
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isTel
    // 機能名   ：  電話番号チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isTel ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^0\d{1,4}?-\d{1,4}?-\d{3,4}$/", $data)
                && !preg_match("/^0\d{4}?-\d{3,4}?$/", $data)
                && !preg_match("/^0120-\d{1,5}?-\d{1,5}$/", $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.";
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isZip
    // 機能名   ：  郵便番号チェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isZip ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^\d{3}-\d{4}$/", $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.";
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isMail
    // 機能名   ：  メールアドレスチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isMail ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match("/^([a-zA-Z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$/", $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.";
        } else {
            // ありえないと思うが長さチェック
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isUrl
    // 機能名   ：  URLチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isUrl ($data, $min, $max, $name) {
        $errMsg = '';

        if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $data)) {
            $errMsg = "Please check the {$name}. A valid {$name} is required.";
        } else {
            // ありえないと思うが長さチェック
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "Please check the {$name}. A valid {$name} is required.";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isHiragana
    // 機能名   ：  全角ひらがなチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isHiragana ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^((\xA4[\xA0-\xF3])||\xA1[\xA1\xBC])*$/", $data)) {
                $errMsg = "{$name}は全角ひらがなで入力してください。";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isKatakana
    // 機能名   ：  全角カタカナチェック
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isKatakana ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^((\xA5[\xA0-\xF6])||\xA1[\xA1\xBC])*$/", $data)) {
                $errMsg = "{$name}は全角カタカナで入力してください。";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isKatakanaEx
    // 機能名   ：  拡張カタカナチェック（全角カタカナ、英数字、「-」、「.」）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isKatakanaEx ($data, $min, $max, $name) {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は半角{$min}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は半角{$min}文字以上、{$max}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }

        if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            if (!preg_match("/^([A-Za-z0-9]|\\-|\\.|((\xA5[\xA0-\xF6])||\xA1[\xA1\xBC]))*$/", $data)) {
                $errMsg = "{$name}は全角カタカナ、半角英数字、「-」、「.」で入力してください。";
            }
        }
        return $errMsg;
    }

    //******************************************************************************
    // 関数名   ：  isText
    // 機能名   ：  テキストチェック（モバイル用、半角カナが含まれている場合、エラーとしない）
    // 引　数   ：  $data       (String)検証データ
    //              $min        (int)最小文字数
    //              $max        (int)最大文字数
    //              $name       (String)項目名
    // 戻り値   ：  (String)エラーメッセージ
    //******************************************************************************
    function isMobileText ($data, $min, $max, $name)
    {
        $errMsg = '';

        // 長さチェック
        $mi = ceil($min / 2);
        $mx = (int)($max / 2);
        if ($min > 0) {         // 最小値指定があるとき
            if (!$this->checkLength($data, $min, $max)) {
                if ($min === $max) {
                    $errMsg = "{$name}は全角{$mi}文字で入力してください。";
                } else {
                    $errMsg = "{$name}は全角{$mi}文字以上、{$mx}文字以内で入力してください。";
                }
            }
        } else {                // 最大値の指定のみ
            if (!$this->checkLengthMax($data, $max)) {
                $errMsg = "{$name}は全角{$mx}文字以内で入力してください。";
            }
        }
        /*if (strlen($errMsg) === 0) {    // 長さチェック通過なら
            // 半角カタカナチェック
            if (preg_match("/(?:\x8E[\xA6-\xDF])/", $data)) {
                $errMsg = "{$name}は半角カタカナ以外で入力してください。";
            }
        }*/
        return $errMsg;
    }

}
?>