<?php
/* cgajardo: función para recuperar el id de la plataforma según el nombre recibido */
function getPlataformas($conexion){
	$sql = 'SELECT * FROM plataformas';
	$plataformaData = mysqli_query($conexion, $sql);
	$plataformaArray = array();
	$i=0;
	while($plataforma = mysqli_fetch_assoc($plataformaData)){
		$plataformaArray[$i] = $plataforma;
		$i++;
	}
	return $plataformaArray;
}

/* función para buscar las personasMoodle que pertenecen a un grupoMoodle */
function usuariosMoodleEnGrupoMoodle($idGrupo, $conexion){
	global $CURRENT;
	global $PREFIX;
	$usuarios = array();
	$sql = 'SELECT gm.userid, r.shortname FROM '.$PREFIX.'groups_members AS gm, '.$PREFIX.'role_assignments AS ra, '.$PREFIX.'role  AS r '.
			'WHERE groupid = '.$idGrupo.' AND ra.userid = gm.userid AND ra.roleid = r.id';
	$resultado = mysqli_query($conexion,$sql);
	$i=0;
	while($row = mysqli_fetch_assoc($resultado)){
		$usuarios[$i] = array('id' => $row['userid'], 'rol' => $row['shortname']);
		$i++;
	}	
	return $usuarios;
}

/* funcion para encontrar el id de una persona através del ID de usuario en moodle */
function usuarioGalyleoPorUsuarioMoodle($usuarioMoodle, $conexion){
	global $CURRENT;
	global $PREFIX;
	$sql = 'SELECT id FROM personas WHERE identificador_moodle = "'.$CURRENT.'_'.$usuarioMoodle.'"';
	$resultado = mysqli_fetch_assoc(mysqli_query($conexion,$sql));
	return $resultado['id'];
}

/* funcion para recuerar el ultimo valor de un parametro en cierta plataforma */
function ultimoValor($plataforma, $parametro, $conexion){	
	$sql = 'SELECT valor FROM estado WHERE id_plataforma = '.$plataforma.' AND variable = "'.$parametro.'"';
	$valueDataResult = mysqli_query($conexion,$sql);
	if(!mysqli_num_rows($valueDataResult)){
		//debug("Plataforma o variable no registradas, se agregarán con valor 0");
		$insert = 'INSERT INTO estado(id_plataforma, variable, valor) VALUES('.$plataforma.', "'.$parametro.'", 0)';
		mysqli_query($conexion,$insert);
		return 0;
	}
	$valueData = mysqli_fetch_assoc($valueDataResult);
	return $valueData['valor'];
}

/* funcion para actualizar el ultimo valor de un parametro en cierta plataforma */
function actualizarUltimoValor($plataforma, $parametro, $valor, $conexion){
	//debug("se actualiza valor a: ".$valor);
	$sql = 'UPDATE estado SET valor = '.$valor.' WHERE id_plataforma = '.$plataforma.' AND variable = "'.$parametro.'"';
	mysqli_query($conexion,$sql);
}

/* funcion para escribir el ultimo valor de un parametro en cierta plataforma */
function debug($message){
	global $DEBUG;
	global $CURRENT;
	if(!$DEBUG) return;
	date_default_timezone_set('America/Santiago');
	$date = date('d-m-Y H:i:s ', time());
	echo '['.$CURRENT.'] '.$date.$message."\n";
}

?>