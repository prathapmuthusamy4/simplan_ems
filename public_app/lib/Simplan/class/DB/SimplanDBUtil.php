<?php

define('CONDITION_LIKE_FRONT',  1);
define('CONDITION_LIKE_BACK',  2);
define('CONDITION_LIKE_BOTH', 3);

class SimplanDBUtil
{
    //******************************************************************************
    // 関数名   ：  makeWhereLike
    // 機能名   ：  LIKE WHERE句を生成する。
    // 引　数   ：  $field, $target, $type
    // 戻り値   ：  string
    // 備　考   ：  none
    //******************************************************************************
    public static function makeWhereLike($field, $target, $type = CONDITION_LIKE_BOTH)
    {
        $ret = "";
        $after = "";
        $escape = '$';

        // check
        if ($field == "" || $field == null) {
            return $ret;
        }

        // add
        if ($target == '%' || $target == '_') {
            $target = "$escape$target";
            $after = "ESCAPE '$escape'";
        }
        if ($type == CONDITION_LIKE_BOTH || $type == CONDITION_LIKE_FRONT) {
            $target = "%$target";
        }
        if ($type == CONDITION_LIKE_BOTH || $type == CONDITION_LIKE_BACK) {
            $target = "$target%";
        }
        $ret = "$field collate utf8_unicode_ci LIKE '$target' $after";

        return $ret;
    }

    //******************************************************************************
    // 関数名   ：  makeWhereIn
    // 機能名   ：  IN WHERE句を生成する。
    // 引　数   ：  $field, $target
    // 戻り値   ：  string
    // 備　考   ：  none
    //******************************************************************************
    public static function makeWhereIn($field, $target)
    {
        $ret = "";

        // check
        if (is_empty($target) || $field == "" || $field == null) {
            return $ret;
        }
        if (is_array($target)) {
           $ret = sprintf("$field IN (%s) ", implode(',', $target));
        } else {
           $ret = "$field IN ($target) ";
        }

        return $ret;
    }

    //******************************************************************************
    // 関数名   ：  makeWhereRegexp
    // 機能名   ：  正規表現 WHERE句を生成する。
    // 引　数   ：  $field, $target
    // 戻り値   ：  string
    // 備　考   ：  none
    //******************************************************************************
    public static function makeWhereRegexp($field, $target)
    {
        $ret = "";

        // check
        if (is_empty($target) || $field == "" || $field == null) {
            return $ret;
        }
        $ret = " $field regexp '^$target$|^$target,|,$target$|,$target,' ";
        return $ret;
    }

    //******************************************************************************
    // 関数名   ：  makeWhere
    // 機能名   ：  配列からWHERE句を生成する。
    // 引　数   ：  $target, $iswhere
    // 戻り値   ：  string
    // 備　考   ：  none
    //******************************************************************************
    public static function makeWhere($target, $iswhere = true)
    {
        $where = "";

        // check
        if (!is_array($target)) {
            return $where;
        }
        if (count($target) > 0) {
            $where = ($iswhere) ? " WHERE " : " AND ";
            // where
            $where .= implode(" AND ", $target);
        }

        return $where;
    }

    //******************************************************************************
    // 関数名   ：  makeLimit
    // 機能名   ：  LIMIT句を生成する。
    // 引　数   ：  $offset, $limit
    // 戻り値   ：  string
    // 備　考   ：  none
    //******************************************************************************
    public static function makeLimit($offset, $limit)
    {
        $ret = "";
        // check
        if (is_empty($offset) || is_empty($limit)) {
            return $ret;
        }
        $ret = " $offset, $limit ";

        return $ret;
    }

}
?>