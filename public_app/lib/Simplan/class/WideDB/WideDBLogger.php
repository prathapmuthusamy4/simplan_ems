<?php

class WideDBLogger{
	var	$path;
	var	$filename;
	var $debug;
	var	$logger;

	function WideDBLogger(){
		$this->logger = NULL;
		$this->path = dirname( dirname( dirname( __FILE__ ) ) ).'/log/';
		$this->filename = "WidDB.log";
		$this->size		= 10240000;
	}
	//--------------------------------------------------------------------------

	function setLogger( $log = NULL ){
		$this->logger = $log;
	}
	//--------------------------------------------------------------------------

	function write($lv, $msg){
		$path = $this->path;
		$name = $this->filename;
		$file = $path.$name;
		if( file_exists($file) ) {
			if( filesize($file) > $this->size ){
				$tmp = explode( '.', $name );
				$num = 1;
				$rename = '';
				while(true){
					if( !file_exists($path.$tmp[0].$num.'.'.$tmp[1]) ){
						$rename = $tmp[0].$num.'.'.$tmp[1];
						break;
					}
					$num ++;
				}
				rename( $file, $path.$rename );
			}
		}

		$fp = fopen( $file, 'a' );
		$msg = date('Y/m/d H:i:s')." >> {$lv} : {$msg}\n";
		fwrite( $fp, $msg );
		fclose( $fp );
	}
	//--------------------------------------------------------------------------

	function debug( $msg ){
		if( !$this->debug ) return;

		if( is_null($this->logger) ) $this->write( 'debug', $msg );
		else $this->logger->debug( $msg );
	}
	//--------------------------------------------------------------------------

	function info( $msg ){
		if( is_null($this->logger) ) $this->write( 'info', $msg );
		else $this->logger->info( $msg );
	}
	//--------------------------------------------------------------------------

	function warning( $msg ){
		if( is_null($this->logger) ) $this->write( 'warning', $msg );
		else $this->logger->warning( $msg );
	}
	//--------------------------------------------------------------------------

	function error( $msg ){
		$this->write( 'error', $msg );
	}
	//--------------------------------------------------------------------------
}
?>
