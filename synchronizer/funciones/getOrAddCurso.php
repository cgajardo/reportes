<?php
function getOrAddCurso($courseid, $connectionLocal, $conectionMoodle){
	global $CURRENT;
	global $PREFIX;
	
	$sql = 'SELECT id FROM cursos WHERE identificador_moodle = "'.$CURRENT.'_'.$courseid.'"';
	$cursoData = mysqli_query($connectionLocal,$sql);
	if(!mysqli_num_rows($cursoData)){
		debug("El curso con ".$CURRENT.'_'.$courseid." no se encuentra en el sistema local. Procede búsqueda");
		$select = 'SELECT fullname, shortname FROM '.$PREFIX.'course WHERE id = '.$courseid;
		$resulSelect = mysqli_query($conectionMoodle,$select);
		//confiamos? mejor no.
		if(!mysqli_num_rows($resulSelect)){
			echo("ERROR CRITICO: Curso (".$courseid.") no existe en el sistema Moodle");
			die();
		}
		$cursoMoodle = mysqli_fetch_assoc($resulSelect);
		$insert = 'INSERT INTO cursos(nombre, nombre_corto, identificador_moodle) VALUES("'.
			$cursoMoodle['fullname'].'", "'.$cursoMoodle['shortname'].'","'.$CURRENT.'_'.$courseid.'")';	
		mysqli_query($connectionLocal,$insert);
		$cursoID = mysqli_insert_id($connectionLocal);
		
	} else {
		$cursoID = mysqli_fetch_assoc($cursoData);
		$cursoID = $cursoID['id'];
	}
	
	return $cursoID;
}
?>