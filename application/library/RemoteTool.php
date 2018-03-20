<?php
/**
* Curl Serivce Class
*   
* @author 子龙<songyang@747.cn>
* @version 1.0
* @date 2014-05-10
*/

class RemoteTool {
	
	static public $timeout = 10;		
	
	/**
	* send request
	*
	* @param  $url
	* @param  $type
	* @param  $args
	* @param  $charset
	*
	* @Returns   
	*/
	public function send($url, $type, $args, $charset = 'utf-8') {
		if ($type == 'post') {
			$returnValue = 	$this->_post($url, $args, $charset);	
		} else {
			$url .= '?' . http_build_query($args);
			$returnValue =  $this->_get($url, $charset);	
		}
		return $returnValue;
	}
	
	private function _post($url, $arguments, $charset = 'utf-8')
	{
		if(is_array($arguments)){
			$postData =  http_build_query($arguments);
		}else{
			$postData = $arguments;
		}

		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);

		$returnValue = curl_exec($ch);
		curl_close($ch);
		if($charset != 'utf-8'){
			$returnValue = iconv($charset,'utf-8',$returnValue);
		}
		return $returnValue;
	}

	private function _get($url, $charset = 'utf-8')
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, self::$timeout);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$returnValue = curl_exec($ch);
		curl_close($ch);
		if($charset != 'utf-8'){
			$returnValue = iconv($charset,'utf-8',$returnValue);
		}
		return $returnValue;
	}
}
