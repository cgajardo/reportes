<?php
/* cgajardo: función encargada de recuperar los grupos y cursos desde desde moodle
 y asignar las relaciones correspondientes en el modelo Galyleo */
 
function procesarGrupos($conectionMoodle, $connectionLocal){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	$ultimoGrupoProcesadoID = ultimoValor($IDPLATAFORM, 'grupo', $connectionLocal);
	$result = mysqli_query($conectionMoodle, 'SELECT * FROM '.$PREFIX.'groups WHERE id > '.$ultimoGrupoProcesadoID);
	
	/* Para cada registro revisamos si tenemos la informacion necesaria */
	while($row = mysqli_fetch_assoc($result)){
		//print_r($row);
		$sql = 'SELECT id FROM grupos WHERE identificador_moodle = "'.$CURRENT.'_'.$row['id'].'"';
		$grupoData = mysqli_query($connectionLocal,$sql);
		if(!mysqli_num_rows($grupoData)){
			$insert = 'INSERT INTO grupos (nombre, identificador_moodle) VALUES("'.
				$row['name'].'","'.$CURRENT.'_'.$row['id'].'")';
			mysqli_query($connectionLocal,$insert);
			$grupoID = mysqli_insert_id($connectionLocal);
		} else {
			$grupoID = mysqli_fetch_assoc($grupoData);
			$grupoID = $grupoID['id'];
		}
		
		//revisamos si ya tenemos el curso 
		$cursoID = getOrAddCurso($row['courseid'], $connectionLocal, $conectionMoodle);
		
		// estamos en condiciones de agregar la relacion cursos_has_grupos
		
		$insert = 'INSERT INTO cursos_has_grupos(id_grupo, id_curso) VALUES('.$grupoID.', '.$cursoID.')';
		mysqli_query($connectionLocal,$insert);
		
		// buscamos ahora las relaciones de grupo y personas
		$usuariosMoodle = usuariosMoodleEnGrupoMoodle($row['id'], $conectionMoodle);
		foreach($usuariosMoodle as $usuario){ 
			$rol = $usuario['rol'];
			$usuarioGalyleo = getOrAddPersona($usuario['id'], $connectionLocal, $conectionMoodle);
			if(trim($rol) == 'teacher'){
				$insert = 'INSERT INTO grupos_has_profesores(id_persona, id_grupo) VALUES('.$usuarioGalyleo.','.$grupoID.')';
			} elseif(trim($rol) == 'student'){
				$insert = 'INSERT INTO grupos_has_estudiantes(id_persona, id_grupo) VALUES('.$usuarioGalyleo.','.$grupoID.')';
			} else {
				$insert = '';
			}
			mysqli_query($connectionLocal,$insert);
			
		}
		
		actualizarUltimoValor($IDPLATAFORM, 'grupo', $row['id'], $connectionLocal);
		
	}
}
?>