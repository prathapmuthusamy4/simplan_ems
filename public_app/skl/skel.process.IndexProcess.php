<?php
include_once( '<!--{$pg_name}-->_common.php' );
/**
 * ##### auto #####  
 *
 * @link       http://simplan.jp/
 * @author     Toru Yoshikawa <yoshikawa@simplan.jp>
 * @license    
 * @package    Simplan
 * @version    1.0
 */

class <!--{$pg_name}-->IndexProcess extends <!--{$pg_name}-->_common
{
	function initProc(){
		$this->table_name	= '<!--{$table_name}-->';
		$this->session_name = <!--{$SessionName}-->_INDEX;
		$this->display = 'index.tpl';
		return array(
			'back'		=> 'executeBack',
			'default'	=> 'executeDefault',
		);
	}
}
?>
