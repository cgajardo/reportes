<?php 
class Encrypter {
	
	/**
	 * @from: http://www.99points.info/2010/06/php-encrypt-decrypt-functions-to-encrypt-url-data/
	 */
	
	var $skey 	= "galyleoFTW"; // changeable
	
	public  function encode($value){
	
		if(!$value){
			return false;
		}
		$text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_3DES, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
		return trim($this->safe_b64encode($crypttext));
	}
	
	public function decode($value){
	
		if(!$value){
			return false;
		}
		$crypttext = $this->safe_b64decode($value);
		$iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_3DES, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
		return trim($decrypttext);
	}
	
	public function decodeURL($value){
		$params = $this->decode($value);
		$key_values = explode('&', $params);
		$ret = array();
		foreach ($key_values as $key_value){
			$values = explode('=', $key_value);
			@$ret[$values[0]] = $values[1];
		}
		
		return $ret;
	} 
 
    private function safe_b64encode($string) {
 
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }
 
	private function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
 
    
}
?>