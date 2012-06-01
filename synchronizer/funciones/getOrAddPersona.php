<?php
function getOrAddPersona($userID, $connectionLocal, $conectionMoodle){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	//si la persona no existe, necesitamos ir a buscarla a moodle y agregarla
	$user = mysqli_query($connectionLocal, 'SELECT id FROM personas WHERE identificador_moodle="'.$CURRENT.'_'.$userID.'"');
	if(!mysqli_num_rows($user)){
		//debug("No se encontró ID de usuario (".$row['userid']."), se procede a recuperar\n");
		//TODO: revisar como separamos los los estudiantes de los profesores.

		$sql = 'SELECT id, firstname, lastname, email, username, password, institution, country FROM '.$PREFIX.'user AS u '.
			'WHERE u.id='.$userID;
		$userInMoodle = mysqli_query($conectionMoodle, $sql);
		//usuarios que fueron eliminados del sistema
		if(!$userInMoodle || !mysqli_num_rows($userInMoodle)){
		return -1;}
		$userInMoodleData = mysqli_fetch_assoc($userInMoodle);
		//requerimos la institucion a la que pertenece cada usuario
		$id_institucion = getOrAddInstitucion($userInMoodleData, $connectionLocal, $conectionMoodle);
		//insertamos el usuario en el sistema de reportes;
		$query ='INSERT INTO personas (nombre, apellido, correo, usuario, password, identificador_moodle, id_institucion) VALUES("'.
				$userInMoodleData['firstname'].'","'.$userInMoodleData['lastname'].'","'.
				$userInMoodleData['email'].'","'.$userInMoodleData['username'].'","'.$userInMoodleData['password'].'","'.
					$CURRENT.'_'.$userInMoodleData['id'].'",'.$id_institucion.')';
		mysqli_query($connectionLocal,$query);
		$userID = mysqli_insert_id($connectionLocal);
	}else{
		$userID = mysqli_fetch_assoc($user);
		$userID = $userID['id'];
	}
	
	return $userID;
}
?>