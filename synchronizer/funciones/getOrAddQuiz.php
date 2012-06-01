<?php
function getOrAddQuiz( $idQuiz, $connectionLocal, $conectionMoodle){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	//si el quiz no existe, necesitamos ir a buscarlo a moodle y agregarlo
		$sql = 'SELECT id_quiz FROM plataforma_quiz WHERE id_plataforma= '.$IDPLATAFORM.' AND id_quiz_moodle = '.$idQuiz;
		$quiz = mysqli_query($connectionLocal,$sql);
		if(!mysqli_num_rows($quiz)){
			debug("No se encontró ID de quiz (".$idQuiz."), se procede a recuperar\n");
			//confiamos en la consistencia de la base de datos de moodle
			
			$sql = 	'SELECT name, course, grade, sumgrades, timeopen, timeclose , timelimit AS duration '.
					'FROM '.$PREFIX.'quiz '.
					'WHERE id='.$idQuiz; 
			
			$quizInMoodle = mysqli_query($conectionMoodle, $sql);
				
			$quizInMoodleData = mysqli_fetch_assoc($quizInMoodle);
			//print_r($quizInMoodleData);
			
			// recuperamos el ID del curso.
			$cursoID = getOrAddCurso($quizInMoodleData['course'], $connectionLocal, $conectionMoodle);
			//revisamos si no tenemos ya el quiz registrado
			$query = 'SELECT id FROM quizes WHERE nombre ="'.$quizInMoodleData['name'].'" AND id_curso='.$cursoID; 
			$quizEnLocal = mysqli_query($connectionLocal,$query);
			//si no lo tenemos, lo agregamos
			if(!mysqli_num_rows($quizEnLocal)){
				//insertamos el quiz en el sistema de reportes
				$query = 'INSERT INTO quizes (nombre, id_curso, fecha_inicio, fecha_cierre, puntaje_maximo, nota_maxima, duracion) '.
						'VALUES ("'.$quizInMoodleData['name'].'",'.$cursoID;
				if($quizInMoodleData['timeopen']){
					$query .= ' ,FROM_UNIXTIME("'.$quizInMoodleData['timeopen'].'"),';}
				else{
					$query .= ' ,0,';}
				if($quizInMoodleData['timeclose']){
					$query .= 'FROM_UNIXTIME("'.$quizInMoodleData['timeclose'].'"), ';}
				else{
					$query .= '0, ';}
				$query .= $quizInMoodleData['sumgrades'].','.
							$quizInMoodleData['grade'].', '.$quizInMoodleData['duration'].')';	
				mysqli_query($connectionLocal,$query);
				$quizID = mysqli_insert_id($connectionLocal);
			} else {
				
				//obtenemos el id del quiz en el sistema de reportes
				$quizID = mysqli_fetch_assoc($quizEnLocal);
				$quizID = $quizID['id'];
				
				/** revisamos la fecha de cierre de este quiz con respecto al que tenemos en el sistema
				* si esta fecha es mayor estamos frente a una correcion y debemos actualizar la fecha de cierre
				* en el sistema de reportes moodle */
				
				$sql = 'UPDATE quizes '. 
						'SET fecha_cierre = IF (quizes.fecha_cierre >= FROM_UNIXTIME("'.$quizInMoodleData['timeclose'].'"), '.
						'quizes.fecha_cierre, FROM_UNIXTIME("'.$quizInMoodleData['timeclose'].'")) '.
						'WHERE quizes.id = '.$quizID;
				
				mysqli_query($connectionLocal,$query);		
						
			}

			
			//agregamos la relacion quiz-plataforma
			$query = 'INSERT INTO plataforma_quiz (id_quiz, id_plataforma, id_quiz_moodle) '.
				'VALUES('.$quizID.','.$IDPLATAFORM.','.$idQuiz.')';
			mysqli_query($connectionLocal,$query);
			
			//necesitamos recuperar todas las preguntas que componen un quiz
			$query = 'SELECT qi.question,qc.id AS category_id, qc.name AS category_name '.
					'FROM '.$PREFIX.'quiz_question_instances AS qi, 
					'.$PREFIX.'question_categories AS qc, '.$PREFIX.'question AS q '.
					'WHERE q.id = qi.question AND q.category = qc.id AND qi.quiz = '.$idQuiz;	
			//echo "como recupero la lista de preguntas en un quiz: \n ".$query."\n";
			$questions = mysqli_query($conectionMoodle,$query);
			
			while ($question = mysqli_fetch_assoc($questions)) {
				
				//buscamos o agregamos la categoria
				/* la categoria ya no es un dato que almacenemos en otra tabla
				$categoryID = getOrAddCategoria($question['category'], $connectionLocal, $conectionMoodle);
				*/
				
				//chequeamos si tenemos la pregunta en el sistema galyleo
				$questionID = getOrAddCategoria($question['category_id'], $connectionLocal, $conectionMoodle);
				
				//realizamos la inserción de la relacion quiz quiz_preguntas
				$sql = 'INSERT INTO quizes_has_categorias(id_quiz, id_categoria) '.
						'VALUES ('.$quizID.','.$questionID.')';
				mysqli_query($connectionLocal,$sql);
			}
			
		}else{
			
			$quizID = mysqli_fetch_assoc($quiz);
			$quizID = $quizID['id_quiz'];	
		}
		
		return $quizID;

}
?>