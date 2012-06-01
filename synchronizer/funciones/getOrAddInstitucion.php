<?php
function getOrAddInstitucion($userDATA, $connectionLocal, $conectionMoodle){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	//si la institucion no existe, necesitamos agregarla
	$institution = mysqli_query($connectionLocal, 'SELECT id FROM instituciones WHERE nombre_corto="'.$userDATA['institution'].'"');
	if(!mysqli_num_rows($institution)){
		debug("No se encontró ID de institucion (".$userDATA['institution']."), se procede a recuperar\n");
		$insert = 'INSERT INTO instituciones (nombre_corto, id_plataforma, pais) '.
				'VALUES ("'.$userDATA['institution'].'",'.$IDPLATAFORM.', "'.$userDATA['country'].'")'; 
		$try = mysqli_query($connectionLocal,utf8_encode($insert));
		if(!$try){print("ALGO FALLÓ. SQL ".$insert."\n"); 
			var_dump($userDATA);
			sleep(10);}
		$institutionID = mysqli_insert_id($connectionLocal);
	}else{
		$institutionID = mysqli_fetch_assoc($institution);
		$institutionID = $institutionID['id'];
	}
	return $institutionID;
}
?>