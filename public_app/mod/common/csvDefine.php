<?php
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
// 請求情報
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
define("HISTORY_CSV_HEAD_LIST", serialize(array(
    "History ID",
    "Name",
    "Login Date&Time",
)));
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
define('T_DIVYA_CSV_HEAD_LIST', serialize(array(
       'REG NO',
       'NAME',
       'DOB',
       'AGE',
       'GENDER',
       'GRADUATE',
       'MARKS',
       'BLOOD',
       'PRIYA ID',
       'HOBBIES',
       'REMARKS',
      )));
define('T_PRIYA_CSV_HEAD_LIST', serialize(array(
       'NAME',
       'DOB',
       'AGE',
       'GENDER',
       'GRADUATE',
       'MARKS',
       'BLOOD',
       'DIVYA ID',
       'HOBBIES',
       'REMARKS',
      )));
//_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
define('M_ADDEMPLOYEE_CSV_HEAD_LIST', serialize(array(
        'EMPLOYEE_ID',
        'NAME',
        'DOB',
        'AADHAR NUMBER',
        'PAN NUMBER',
        'PASSPORT',
        'EXPIRY DATE',
        'MOB NUM',
       )));
?>
