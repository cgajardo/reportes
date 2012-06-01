<?php
/* cgajardo: función encargada de recuperar los grupos y cursos desde desde moodle
 y asignar las relaciones correspondientes en el modelo Galyleo */
 
function procesarPersonas($conectionMoodle, $connectionLocal){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	$ultimaPersonaProcesadoID = ultimoValor($IDPLATAFORM, 'persona', $connectionLocal);
	$sql = 'SELECT id, firstname, lastname, email, username, password, institution, country FROM '.$PREFIX.'user AS u '.
			'WHERE u.id > '.$ultimaPersonaProcesadoID;
	
	$result = mysqli_query($conectionMoodle, $sql);
	
	debug("Se procesarán : ".mysqli_num_rows($result)." registros de Personas \n");
	
	/* Para cada registro revisamos si ya tenemos al usuario desde otra plataforma */
	while($row = mysqli_fetch_assoc($result)){
		//print_r($row);
		$sql = 'SELECT id FROM personas WHERE usuario = "'.$row['username'].'"';
		$personasData = mysqli_query($connectionLocal,$sql);
		if(!mysqli_num_rows($personasData)){
			$id_institucion = getOrAddInstitucion($row, $connectionLocal, $conectionMoodle);
			//insertamos el usuario en el sistema de reportes;
			$insert ='INSERT INTO personas (nombre, apellido, correo, usuario, password, identificador_moodle,  id_institucion) VALUES("'.
					$row['firstname'].'","'.$row['lastname'].'","'.
					$row['email'].'","'.$row['username'].'","'.$row['password'].'","'.
					$CURRENT.'_'.$row['id'].'",'.$id_institucion.')';
			
			$try = mysqli_query($connectionLocal,$insert);
			if(!$try){
				print("ALGO FALLÓ. SQL ".$insert."\n"); sleep(10);
			}
			echo "Se inserto usuario: ". $row['id']."\n";
		} 
		actualizarUltimoValor($IDPLATAFORM, 'persona', $row['id'], $connectionLocal);
	}
	
	debug("Se procesaron todos los nuevos registros de personas");
}
?>