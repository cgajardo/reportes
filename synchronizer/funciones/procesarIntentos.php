<?php
/* cgajardo: función encargada de procesar, a partir de los intentos, todas las notas, controles, preguntas y usuarios */
function procesarIntentos($conectionMoodle, $connectionLocal) {
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	$ultimoIntentoProcesadoID = ultimoValor($IDPLATAFORM, 'intento', $connectionLocal); 
	$sql = 'SELECT * FROM '.$PREFIX.'quiz_attempts WHERE id > '.$ultimoIntentoProcesadoID;
	$result = mysqli_query($conectionMoodle, $sql);
	
	/** para cada registro revisamos que tenemos la info necesaria **/
	debug("Se procesarán : ".mysqli_num_rows($result)." registros de Intentos \n");
	$i = 1;
	while ($row = mysqli_fetch_assoc($result)) {
		
		$quizID = getOrAddQuiz( $row['quiz'], $connectionLocal, $conectionMoodle);
		 
		$userID = getOrAddPersona($row['userid'], $connectionLocal, $conectionMoodle);
		if($userID==-1){
			debug("ALGO FALLO en usuario");}
		
		//cgajardo: ahora insertamos el puntaje obtenido en cada intento
		/**
		$sql = 'SELECT st.question, st.grade*qz.grade/qz.sumgrades as NotaPregunta, st.grade/qqi.grade as "%LogroPregunta", '.
				'st.timestamp as Fecha '.
				'FROM '.$PREFIX.'question_states st '.
				'JOIN '.$PREFIX.'question_sessions sess ON st.question = sess.questionid AND st.attempt = sess.attemptid '.
				'JOIN '.$PREFIX.'quiz_attempts quiza ON quiza.uniqueid = sess.attemptid '.
				'JOIN '.$PREFIX.'quiz qz ON qz.id = quiza.quiz '.
				'JOIN '.$PREFIX.'quiz_question_instances qqi on (qz.id = qqi.quiz and st.question = qqi.question) '.
				'WHERE quiza.userid='.$row['userid'].' and quiza.quiz='.$row['quiz'].' and st.event = 6 AND st.attempt = '.$row['id'].' '.
				'ORDER BY question';
		**/
		
		$sql = 'SELECT qs.question, max(qs.raw_grade) as grade, timestamp, qqi.grade as raw_grade '.
		'FROM '.$PREFIX.'question_states AS qs, '.$PREFIX.'quiz_question_instances AS qqi '.
		'WHERE qs.question = qqi.question AND qs.attempt ='.$row['id'].' '.
		'GROUP BY qs.question';
		 
		$gradeData = mysqli_query($conectionMoodle,$sql);
		// si no hay data es probable que estemos en un sistema 2.0+
		if(!mysqli_num_rows($gradeData)){
			
/** Intento fallido pero que permitio entender mejor el sistema 2.0+ **/
// 			$sql = 'SELECT  qa.questionid AS question, max(qas.fraction)*qa.maxmark AS grade, qas.timecreated AS timestamp, max(qas.fraction) AS raw_grade '.
// 			'FROM '.$PREFIX.'question_attempt_steps AS qas, '.$PREFIX.'question_attempts AS qa, '.$PREFIX.'quiz_attempts AS quiza '.
// 			'WHERE qas.questionattemptid = qa.id '.
// 			'AND quiza.uniqueid = qa.questionusageid '.
// 			'AND quiza.id = '.$row['id'].' '.
// 			'GROUP BY qa.questionid';
			
			$sql = 'SELECT *
					FROM (
						SELECT qi.id,pi.questionid,qas.fraction*pi.maxmark AS mark, pi.maxmark,FROM_UNIXTIME(timefinish) AS time,qi.attempt
						FROM '.$PREFIX.'quiz_attempts qi
						JOIN  '.$PREFIX.'question_attempts pi ON questionusageid =qi.uniqueid
						JOIN  '.$PREFIX.'question_attempt_steps qas ON questionattemptid = pi.id
						WHERE quiz='.$row['id'].' AND qi.userid='.$row['userid'].'
						ORDER BY sequencenumber DESC) AS t
					GROUP BY id,questionid,attempt';
			
			$gradeData = mysqli_query($conectionMoodle,$sql);
			//Si ahora no hay data, no tenemos nada que hacer
			if(!mysqli_num_rows($gradeData)){
				debug("No Hay notas en este intento. IdIntentoMoodle:".$row['id']." \n");
				actualizarUltimoValor($IDPLATAFORM, 'intento', $row['id'], $connectionLocal);
				continue;
			}
		}
			
		while ($grade = mysqli_fetch_assoc($gradeData)) {
			//insertamos el intento en la base de datos
			$preguntaID = getOrAddPregunta($grade['questionid'], $connectionLocal, $conectionMoodle);
			if(is_null($grade['mark'])){
				$grade['mark']=0;
			}
			if(isset($row['time']))
				$sql = 'INSERT INTO intentos (id_persona,id_quiz, id_pregunta, puntaje_alumno, maximo_puntaje, fecha, numero_intento) VALUES('.
					$userID.','.$quizID.','.$preguntaID.','.$grade['mark'].','.$grade['maxmark'].',"'.$row['time'].'",'.$row['attempt'].')';
			else
				$sql = 'INSERT INTO intentos (id_persona,id_quiz, id_pregunta, puntaje_alumno, maximo_puntaje, fecha, numero_intento) VALUES('.
					$userID.','.$quizID.','.$preguntaID.','.$grade['mark'].','.$grade['maxmark'].',0,'.$row['attempt'].')';
			$try = mysqli_query($connectionLocal,$sql);
			
			if(!$try || $userID==-1){ print("ALGO FALLÓ. SQL ".$sql." \n ".$queryPreguntaID."\n");
			print_r ($grade);}
			
		}
		actualizarUltimoValor($IDPLATAFORM, 'intento', $row['id'], $connectionLocal);	
	}
	debug("Se procesaron todos los nuevos intentos");
}
?>