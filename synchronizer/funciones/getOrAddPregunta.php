<?php
/**
* @author cgajardo
* @version 1.0
*/

function getOrAddPregunta($pregunta_id, $connectionLocal, $conectionMoodle){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	$queryPreguntaID = 'SELECT id FROM preguntas WHERE identificador_moodle = "'.$CURRENT.'_'.$pregunta_id.'"';
	$preguntaDATA = mysqli_query($connectionLocal, $queryPreguntaID);
	
	//si la pregunta no existe, necesitamos agregarla
	if(!mysqli_num_rows($preguntaDATA)){
		//buscamos el nombre de la pregunta en el sistema moodle
		//confiamos en la consistencia de moodle
		$queryName = 'SELECT q.name as question_name, qc.id AS category_id '.
					'FROM '.$PREFIX.'question_categories AS qc, '.$PREFIX.'question AS q '. 
					'WHERE q.category = qc.id AND q.id = '.$pregunta_id;
		
		
		$questionData =mysqli_fetch_assoc(mysqli_query($conectionMoodle,$queryName));
		//buscamos la categoria en el sistema local
		$id_categoria = getOrAddCategoria($questionData['category_id'], $connectionLocal, $conectionMoodle);
		//Agregamos la pregunta
		$query ='INSERT INTO preguntas (nombre, identificador_moodle, id_categoria) VALUES("'.utf8_encode($questionData['question_name']).'","'.$CURRENT.'_'.$pregunta_id.'",'.$id_categoria.')';
		if($id_categoria==-1){
			echo $query."\n";
		}
		mysqli_query($connectionLocal,$query);
		$preguntaID = mysqli_insert_id($connectionLocal);
		if(!($preguntaID%1000)){
			echo "Se inserto pregunta ".$preguntaID."\n";
		}
		
	}else{
		$preguntaDATA = mysqli_fetch_assoc($preguntaDATA);
		$preguntaID = $preguntaDATA['id'];
	}
	
	return $preguntaID; 
}					

?>