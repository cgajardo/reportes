<?php
/* cgajardo: función encargada de recuperar los grupos y cursos desde desde moodle
 y asignar las relaciones correspondientes en el modelo Galyleo */
 
function procesarPreguntas($conectionMoodle, $connectionLocal){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	$ultimaPreguntaProcesadoID = ultimoValor($IDPLATAFORM, 'pregunta', $connectionLocal);
	$sql = 'SELECT id,name,category FROM '.$PREFIX.'question AS q '.
			'WHERE q.id > '.$ultimaPreguntaProcesadoID.' ORDER BY category';
	
	$last_category_moodle = -1;
	$last_category_local = -1;
	
	$result = mysqli_query($conectionMoodle, $sql);
	
	debug("Se procesarán : ".mysqli_num_rows($result)." registros de Preguntas \n");
	
	/* Para cada registro revisamos si ya tenemos al usuario desde otra plataforma */
	while($row = mysqli_fetch_assoc($result)){
		//print_r($row);
		
		//buscamos la categoria en el sistema local
		if($row['category']==$last_category_moodle){
			$query ='INSERT INTO preguntas (nombre, identificador_moodle, id_categoria) VALUES("'.utf8_encode($row['name']).'","'.$CURRENT.'_'.$row['id'].'",'.$last_category_local.')';
		}else{
			$id_categoria = getOrAddCategoria($row['category'], $connectionLocal, $conectionMoodle);
			//Agregamos la pregunta
			$query ='INSERT INTO preguntas (nombre, identificador_moodle, id_categoria) VALUES("'.utf8_encode($row['name']).'","'.$CURRENT.'_'.$row['id'].'",'.$id_categoria.')';
		}
		mysqli_query($connectionLocal,$query);
		$preguntaID = mysqli_insert_id($connectionLocal);
		if(!($preguntaID%1000)){
			echo "Se inserto pregunta ".$preguntaID."\n";
		}
	
		actualizarUltimoValor($IDPLATAFORM, 'pregunta', $row['id'], $connectionLocal);
	}
	
	debug("Se procesaron todos los nuevos registros de pr");
}
?>