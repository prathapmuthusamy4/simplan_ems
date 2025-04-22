<?php

/**
 *  listProcess
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license
 * @package    Simplan
 * @version    1.0
 */

include_once("addEmployeeCommon.php");

class listProcess extends addEmployeeCommon
{
    /**
     * 初期設定
     *
     * @access    public
     * @return    array    コマンドリスト
     */
    function initProc()
    {
        $this->table_name   = "m_addemployee";
        $this->session_name = ADMIN_ADD_EMPLOYEE_LIST_SESSION;
        $this->page_record  = "addemployee_page_record";
        $this->display      = "list.tpl";
        // cmd
        $cmd = [
            "reload"      => "executeReload",
            "change_page" => "executeChangePage",
            "search"      => "executeSearch",
            "default"     => "executeDefault",
            "excel"       => "executeDownload",
        ];

        return $cmd;
    }

    /**
     * 表示パラメータ初期化
     *
     * @access    public
     * @return    array    出力パラメータ
     */
    function initParam()
    {
        // init
        $param = array(
            "f_emp_id"         => "",
            "f_name"           => "",
            "f_image"          => "",
            "f_emp_status"     => "",
            "f_expiry_date"    => "",
            "f_issue_date"     => "",
            "f_date_of_birth"  => "",
            "f_aadhar_number"  => "",
            "f_pan_number"     => "",
            "f_passport"       => "",
            "f_mobile_number"  => "",
            "f_passport_alert" => "",
            "f_language"       => "",
            'disp_language'    => unserialize(ALLOW_LANGUAGE_LIST),
            'disp_emp_status'  => unserialize(ALLOW_EMP_STATUS_LIST),
            'url_img'          => $this->img_obj->getIniSiteValue('img_dir_profile_photo'),
            "list"             => array(),
            "csv_list"         => [],
            "none"             => $this->getMessage(STATUS_COMMON, "C_0014"),
            "errmsg"           => $this->initErrmsg(),
            "pno"              => 1,
            "page_info"        => "",
        );
        return $param;
    }

    /**
     * エラーメッセージ初期化
     *
     * @access    public
     * @return    array    エラーメッセージ
     */
    function initErrmsg()
    {
        // init
        $errmsg = array(
            "f_emp_id"         => "",
            "f_name"           => "",
            "f_emp_status"     => "",
            "f_expiry_date"    => "",
            "f_issue_date"     => "",
            "f_passport_alert" => "",
            "f_language"       => "",
            "system"           => "",
        );
        return $errmsg;
    }

    /**
     * デフォルト処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeDefault($input)
    {
        $success = false;
        // session clear
        $this->clearSession();
        // list
        $this->searchData($this->param);
        $this->passportCheck($this->param);
        // set
        $this->setSession($input, $this->param);
        $success = true;
        return $success;
    }

    /**
     * リロード処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeReload($input)
    {
        $success = false;
        // get session
        $this->setParamFromSession($this->param);
        // list
        $this->searchData($this->param);
        $this->passportCheck($this->param);
        // session set
        $this->setSession($input, $this->param);

        return $success = true;
    }

    /**
     * 改ページ処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeChangepage($input)
    {
        $success = false;

        // get session
        $this->setParamFromSession($this->param);
        $this->param["pno"] = $input["pno"];
        // list
        $this->searchData($this->param);
        $this->passportCheck($this->param);
        // session set
        $this->setSession($input, $this->param);

        return $success = true;
    }

    /**
     * 検索処理
     *
     * @access    public
     * @param     array    $input   入力値
     * @return    bool
     */
    function executeSearch($input)
    {
        $success = false;
        // set input
        $this->setInputData($input, $this->param);
        // $this->param['f_language'] = (isset($input['f_language'])) ? t_implode($input["f_language"], ",") : NULL;
        // list
        $this->searchData($this->param);
        // $this->param['f_language'] = (isset($this->param['f_language'])) ? t_explode($this->param["f_language"], ",") : NULL;
        // $this->param['f_language'] = (isset($input['f_language'])) ? $input["f_language"] : NULL;


        // print_r($this->param);exit;
        $this->passportCheck($this->param);
        // session set
        $this->setSession($input, $this->param);
        return $success = true;
    }

    /**
     * 検索処理
     *
     * @access    public
     * @param     array    $param   出力情報
     * @return    bool
     */
    function passportCheck($param)
    {
        $success = false;
        // get session
        $curdate = date("Y/m/d");
        $prevmonth = date('Y/m/d', strtotime('+2 months'));
        $list = $param['list'];
        foreach ($list as $key => $value) {
            if (!is_null($value['f_expiry_date'])) {
                if ($value['f_expiry_date'] == $curdate) {
                    $this->param['list']["{$key}"]['f_passport_alert'] = '1';
                }
                else {
                   if($value['f_expiry_date'] <= $prevmonth) {
                        $this->param['list']["{$key}"]['f_passport_alert'] = '2';
                    }
                }
                if ($value['f_expiry_date'] < $curdate) {
                    $this->param['list']["{$key}"]['f_passport_alert'] = '3';
                }
            }
        }
        $success = true;

        return $list;
    }

        /**
    * CSVダウンロード for m_addemployee table data
    *
    * @access    public
    * @param     array    $input   入力値
    * @return    bool
    */
   function executeDownload($input)
   {
        $success = false;
        // list
        $this->logger->debug("Entering CSV Download...");
        // set
        $this->setParamFromSession($this->param);
        // list
        $this->searchEmployeeCsvData();
        $cacheMethod   = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
        $cacheSettings = array("dir" => "/tmp");
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $this->reader = PHPExcel_IOFactory::createReader("Excel2007");
        $fileName     = DATA_DIR . "employeedetails.xlsx";
        $this->excel  = $this->reader->load($fileName);
        $this->makeTemplateExcel($input,$this->param);
        $this->makeExcelFile("employeedetails");
        $this->logger->debug("Finished CSV Download...");
        $this->setSession($input, $this->param);
        $success = true;
        return $success;
   }

   /**
     * 請求書を作成する
     *
     * @access    private
     * @return    void
     */
    private function makeTemplateExcel($input,&$param)
    {
        $this->excel->setActiveSheetIndex(0);
        $this->sheet = $this->excel->getActiveSheet();
        $csv_list = $this->param['csv_list'];
        $i = 2;
        foreach ($csv_list as $key => $value) {
            $this->sheet->setCellValue("A{$i}",  $key + 1);
            $this->sheet->setCellValue("B{$i}",  $value['f_emp_id']);
            $this->sheet->setCellValue("C{$i}",  $value['f_name']);
            $this->sheet->setCellValue("D{$i}",  $value['f_date_of_birth']);
            $this->sheet->setCellValue("E{$i}",  $value['f_aadhar_number']);
            $this->sheet->setCellValue("F{$i}",  $value['f_pan_number']);
            $this->sheet->setCellValue("G{$i}",  $value['f_passport']);
            $this->sheet->setCellValue("H{$i}",  $value['f_issue_date']);
            $this->sheet->setCellValue("I{$i}",  $value['f_expiry_date']);
            $this->sheet->setCellValue("J{$i}",  $value['f_mobile_number']);
            $i = $i + 1;
        }

        return;
    }

    /**
     * エクセルファイルを生成する
     *
     * @access    private
     * @param     string    接頭辞
     * @param     string    取次店コード
     * @return    void
     */
    private function makeExcelFile($excelname)
    {
        $excelFile = $this->getExcelFileName($excelname);
        ob_start();
        $writer    = PHPExcel_IOFactory::createWriter($this->excel, "Excel2007");
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=\"{$excelname}.xlsx\"");
        header("Cache-Control: max-age=0");
        ob_implicit_flush(1);
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();
        die($content);
    }

    /**
     * エクセルファイル名を取得する
     *
     * @access    private
     * @param     string    接頭辞
     * @param     string    取次店コード
     * @return    string    エクセルファイル名
     */
    private function getExcelFileName($prefix)
    {
        $excelDir = DATA_DIR . "excel/";
        $fileName = "{$excelDir}/{$prefix}_excel_data.xlsx";
        $this->logger->debug("---------------->取次店請求書ファイル名:{$fileName}");
        return $fileName;
    }
}
?>
