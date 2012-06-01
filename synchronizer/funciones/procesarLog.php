<?php
function procesarLog($conectionMoodle, $connectionLocal){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	$ultimoLogProcesadoID = ultimoValor($IDPLATAFORM, 'log', $connectionLocal);
	
	$sql = 'SELECT id, time, userid, module, action, url FROM '.$PREFIX.'log WHERE id > '.$ultimoLogProcesadoID;
	$result = mysqli_query($conectionMoodle,$sql);

	debug("Se procesarán : ".mysqli_num_rows($result)." registros de Log \n");
	
	while ($row = mysqli_fetch_assoc($result)) {
		//No necesitamos chequear si tenemos el LOG, es definitivo que no lo tenemos
		$userID = getOrAddPersona($row['userid'], $connectionLocal, $conectionMoodle);
		$urlData = explode('=', $row['url']);
		if(isset($urlData[1])){
			$pos = strpos($urlData[1],'&');
		}else{
			$pos = 0;
		}
		
		if($pos) {
			$id_modulo = $urlData[1];
			$insert = 'INSERT INTO logs(id_persona, tiempo, modulo, accion, id_modulo) '.
					'VALUES('.$userID.', '.$row['time'].', "'.$row['module'].'","'.$row['action'].'",'.$id_modulo.')';
		}
		else {
			if(isset($urlData[1])){
				$urlData = explode('&', $urlData[1]);
			}
			$id_modulo = $urlData[0];
			$insert = 'INSERT INTO logs(id_persona, tiempo, modulo, accion, id_modulo) '.
					'VALUES('.$userID.', '.$row['time'].', "'.$row['module'].'","'.$row['action'].'",'.$id_modulo.')';
		}
		
		mysqli_query($connectionLocal, $insert);
		actualizarUltimoValor($IDPLATAFORM, 'log', $row['id'], $connectionLocal);
		
		//si se trata de un intento vamos a sumar el tiempo que estuvo resolviendo el intento
		if($row['action'] == 'attempt'){
			$sql = 'SELECT timefinish FROM '.$PREFIX.'quiz_attempts WHERE id = '.$id_modulo;
			$attemptData = mysqli_fetch_assoc(mysqli_query($conectionMoodle,$sql));
			if($attemptData['timefinish']>0){
				$insert = 'INSERT INTO logs(id_persona, tiempo, modulo, accion, id_modulo) '.
						'VALUES('.$userID.', '.$attemptData['timefinish'].',"'.$row['module'].'","manual",'.$id_modulo.')';
				mysqli_query($connectionLocal, $insert);
			}
			
		}
		
		
	}
	debug("Se procesaron todos los nuevos logs");
}
?>