<?php

function safe_b64encode($string) {

	$data = base64_encode($string);
	$data = str_replace(array('+','/','='),array('-','_',''),$data);
	return $data;
}

function safe_b64decode($string) {
	$data = str_replace(array('-','_'),array('+','/'),$string);
	$mod4 = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	return base64_decode($data);
}

function encode($value){

	if(!$value){
		return false;
	}
	$text = $value;
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, "galyleoFTW", $text, MCRYPT_MODE_ECB, $iv);
	return trim(safe_b64encode($crypttext));
}

function decode($value){

	if(!$value){
		return false;
	}
	$crypttext = safe_b64decode($value);
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, "galyleoFTW", $crypttext, MCRYPT_MODE_ECB, $iv);
	return trim($decrypttext);
}



/**
 * cgajardo: recibe un arreglo de notas y devuelve el promedio de estas
 * @param array $notas
 */
function promedio_grupo($notas, $total_estudiantes){
	$i=0;
	$suma = 0;
	foreach ($notas as $nota){
		$i++;
		$suma+=$nota->nota;
	}
	return round($suma/$total_estudiantes);
	//return round($suma/$i);
} 

function posicion($notas_grupo, $nota_alumno){
	$i=0;
	foreach ($notas_grupo as $nota){
		$i++;
		if($nota->nota == $nota_alumno->nota){
			return $i;
		}
	}
}
?>