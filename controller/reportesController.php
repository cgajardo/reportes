<?php

Class reportesController Extends baseController {

public function index() 
{
	//print $this->encrypter->encode("platform=utfsm&user=609&course=6");
	$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	
	$user_id_in_moodle = $PARAMS['user'];
	$platform = $PARAMS['platform'];
	
	$usuario = DAOFactory::getPersonasDAO()->getUserInPlatform($platform,$user_id_in_moodle);
	$cursos_usuarios = DAOFactory::getCursosDAO()->getCursosByUsuario($usuario->id);
	
	// redireccionamos al 404 si usuario no existe
	if($usuario == null){
		$this->registry->template->mesaje_personalizado = "Debes ser un usuario de Galyleo para visitar esta p&aacute;gina.</br>".
				"Si tu cuenta fue creada recientemente debes esperar un par de minutos a que nuestros sistemas se actualicen.";
		//finally
		$this->registry->template->show('error404');
		return;
	}
	
	elseif ($cursos_usuarios == null){
		$this->registry->template->mesaje_personalizado = "Tu cuenta no est&aacute; asociada a ning&uacute;n curso.</br>".
				"Probablemente llegaste hasta ac&aacute; por error.";
		//finally
		$this->registry->template->show('error404');
		return;
	}
	 
	
	elseif (isset($PARAMS['quiz'])){
		$id_quiz = $PARAMS['quiz'];
		
		$quiz = DAOFactory::getQuizesDAO()->load($id_quiz);
		$nota_alumno = DAOFactory::getIntentosDAO()->getNotaInQuizByPersona($quiz->id, $usuario->id);
		$contenido_logro = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz->id, $usuario->id);
		
		$this->registry->template->usuario = $usuario;
		$this->registry->template->quiz = $quiz;
		$this->registry->template->nota = $nota_alumno;
		$this->registry->template->contenido_logro=$contenido_logro;
		$this->registry->template->origen = '&platform='.$platform.'&user='.$user_id_in_moodle.'&curso='.$PARAMS['curso'];
		$this->registry->template->encrypter = $this->encrypter;
		
		//finally
		$this->registry->template->show('reportes/index_detalle');
		
		return;
		
	}
	
	elseif (isset($PARAMS['curso'])){
		$id_curso = $PARAMS['curso'];
		
		$quizes = DAOFactory::getQuizesDAO()->queryEvaluacionesByIdCurso($id_curso);
		
		$this->registry->template->usuario = $usuario;
		$this->registry->template->cursos = $cursos_usuarios;
		$this->registry->template->origen = '&platform='.$platform.'&user='.$user_id_in_moodle;
		$this->registry->template->encrypter = $this->encrypter;
		$this->registry->template->quizes = $quizes;
		$this->registry->template->id_curso = $id_curso;
		
		//finally
		$this->registry->template->show('reportes/index_quizes');
		
		return;
	}
	
	/* caso en que el usuario ya selecciono el curso desde la plataforma moodle */
	elseif (isset($PARAMS['course'])){
		$curso_moodle = $PARAMS['course'];
		$curso = DAOFactory::getCursosDAO()->queryByIdentificadorMoodle($platform.'_'.$curso_moodle);
		//sabemos que el identificador_moodle es único, por lo tanto recibiremos sólo 1 respuesta
		$curso = $curso[0];
		
		$quizes = DAOFactory::getQuizesDAO()->queryEvaluacionesByIdCurso($curso->id);
		
		$this->registry->template->usuario = $usuario;
		$this->registry->template->cursos = $cursos_usuarios;
		$this->registry->template->origen = '&platform='.$platform.'&user='.$user_id_in_moodle;
		$this->registry->template->encrypter = $this->encrypter;
		$this->registry->template->quizes = $quizes;
		$this->registry->template->id_curso = $curso->id;
		
		//finally
		$this->registry->template->show('reportes/index_quizes');
		
		return;
	}
	
	$this->registry->template->usuario = $usuario;
	$this->registry->template->cursos = $cursos_usuarios;
	$this->registry->template->origen = '&platform='.$platform.'&user='.$user_id_in_moodle;
	$this->registry->template->encrypter = $this->encrypter;
    //finally
    $this->registry->template->show('reportes/index_cursos');
}

/* esta función es sólo un ejemplo del uso de Google Chart */
public function semanal(){
	print $this->encrypter->encode("platform=utfsm&user=609&course=6&quiz=151")."</br>";
	print $this->encrypter->encode("plataforma=utfsm&usuario=848&curso=6&quiz=21");
	//578, 586, 587, 599, 581, 574
	
	$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	
	if(isset($PARAMS['platform'])){
		$user_id_in_moodle = $PARAMS['user'];
		$platform = $PARAMS['platform'];
		$course_id_in_moodle = $PARAMS['course'];
		$quiz_id_in_moodle = $PARAMS['quiz'];
		
		//recuperamos los objetos que nos interesan
		$usuario = DAOFactory::getPersonasDAO()->getUserInPlatform($platform,$user_id_in_moodle);
		$curso = DAOFactory::getCursosDAO()->queryByIdentificadorMoodle($platform.'_'.$course_id_in_moodle);
		$quiz = DAOFactory::getQuizesDAO()->getGalyleoQuizByMoodleId($platform, $quiz_id_in_moodle);
	
	}
	elseif(isset($PARAMS['plataforma'])){
		$user_id = $PARAMS['usuario'];
		$platform = $PARAMS['plataforma'];
		$course_id = $PARAMS['curso'];
		$quiz_id = $PARAMS['quiz'];
		
		//recuperamos los objetos que nos interesan
		$usuario = DAOFactory::getPersonasDAO()->load($user_id);
		$curso = DAOFactory::getCursosDAO()->load($course_id);
		$quiz = DAOFactory::getQuizesDAO()->load($quiz_id);
	}
	
	$grupo = DAOFactory::getGruposDAO()->getGrupoByCursoAndUser($usuario->id, $curso->id);
	$estudiantes_en_grupo = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
	$notas_grupo = DAOFactory::getIntentosDAO()->getNotasGrupo($quiz->id,$grupo->id);
	$nota_alumno = DAOFactory::getIntentosDAO()->getNotaInQuizByPersona($quiz->id, $usuario->id);
	$contenido_logro = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz->id, $usuario->id);
	
	// esto es lo necesario para la matriz de desempeño, TODO: debería tener su vista propia?
	$quizes_en_curso = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($curso->id);
	$matriz_desempeño = array();
	foreach ($quizes_en_curso as $quiz_en_curso){
		$logro_contenido = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz_en_curso->id, $usuario->id);
		if(empty($logro_contenido)){
			$matriz_desempeño[$quiz_en_curso->nombre] = DAOFactory::getContenidosDAO()->getContenidosByQuiz($quiz_en_curso->id);
		}else{
			$matriz_desempeño[$quiz_en_curso->nombre] = $logro_contenido;
		}
			
	}
	
	//calculamos el tiempo que paso el usuario entre quizes
	//$inicio = '1970-01-01 12:00:00';
	//hoy será hace 1 mes atrás
	$hoy = time() - (3 * 7 * 24 * 60 * 60);
	$semana_pasada = $hoy - (7 * 24 * 60 * 60);
	$tiempos_semanas = array();
	for ($i = 0; $i<10; $i++){
		$tiempos_semanas[ date("d/m",$semana_pasada)] = DAOFactory::getLogsDAO()->getTiempoEntreFechas($semana_pasada,$hoy, $usuario->id);
		$hoy = $semana_pasada;
		$semana_pasada = $hoy - (7 * 24 * 60 * 60);
	}
	
	//enviamos los siguientes valores a la vista
	$this->registry->template->titulo = 'Reporte Estudiante';
	$this->registry->template->usuario = $usuario;
	$this->registry->template->notas_grupo = $notas_grupo;
	$this->registry->template->promedio_grupo = promedio_grupo($notas_grupo,count($estudiantes_en_grupo));
	$this->registry->template->nota_alumno = $nota_alumno[0];
	$this->registry->template->posicion_en_grupo = posicion($notas_grupo, $nota_alumno[0]);
	$this->registry->template->total_estudiantes_grupo = count($estudiantes_en_grupo);
	$this->registry->template->nombre_actividad = $quiz->nombre;
	$this->registry->template->fecha_cierre = $quiz->fechaCierre;
	$this->registry->template->contenido_logro = $contenido_logro;
	$this->registry->template->nombre_curso = $curso->nombre;
	$this->registry->template->nombre_grupo = $grupo->nombre;
	$this->registry->template->institucion = 'utfsm';
	$this->registry->template->matriz_desempeño = $matriz_desempeño;
	$this->registry->template->tiempos_semanas = $tiempos_semanas;
	
	
	//finally
	$this->registry->template->show('reportes/alumno');
	
}

public function profesor(){
	$user_id_in_moodle = $_GET['user'];
	$platform = $_GET['platform'];
	$grupo_id_in_moodle = $_GET['group'];
	$quiz_id_in_moodle = $_GET['quiz'];
	
	//recuperamos los objetos que nos interesan
	$grupo = DAOFactory::getGruposDAO()->getGrupoByIdEnMoodle($platform,$grupo_id_in_moodle);
	$curso = DAOFactory::getCursosDAO()->getCursoByGrupoId($grupo->id);
	$estudiantes_en_grupo = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
	$quiz = DAOFactory::getQuizesDAO()->getGalyleoQuizByMoodleId($platform, $quiz_id_in_moodle);
	$notas_grupo = DAOFactory::getIntentosDAO()->getNotasNombreGrupo($quiz->id,$grupo->id);
	$contenido_logro = DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupo($quiz->id);
        //$nota_maxima= DAOFactory::getNotasDAO()->getMaxNotaInQuiz($quiz->id);
	
	//enviamos los siguientes valores a la vista
	$this->registry->template->titulo = 'Reporte Profesor';
	$this->registry->template->usuario = $usuario;
	$this->registry->template->notas_grupo = $notas_grupo;
	$this->registry->template->nota_maxima = 100;
	$this->registry->template->promedio_grupo = promedio_grupo($notas_grupo,count($estudiantes_en_grupo));
	$this->registry->template->estudiantes =$estudiantes_en_grupo;
    $this->registry->template->total_estudiantes_grupo = count($estudiantes_en_grupo);
	$this->registry->template->nombre_actividad = $quiz->nombre;
	$this->registry->template->fecha_cierre = $quiz->fechaCierre;
	$this->registry->template->contenido_logro = $contenido_logro;
	$this->registry->template->nombre_curso = $curso->nombre;
	$this->registry->template->nombre_grupo = $grupo->nombre;
	
	// esto es lo necesario para la matriz de desempe�o, TODO: deber�a tener su vista propia?
	$quizes_en_curso = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($curso->id);
	$matriz_desempeno = array();
	foreach ($quizes_en_curso as $quiz_en_curso){
                $contenidos=DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupo($quiz_en_curso->id);
		$matriz_desempeno[$quiz_en_curso->nombre] = promedio_grupo($contenidos,count($estudiantes_en_grupo));
	}
	
	//enviamos estos elementos a la vista
	$this->registry->template->matriz_desempeno = $matriz_desempeno;
	
	//tiempo dedicado frente a cada quiz
	$tiempo_decicado = DAOFactory::getLogsDAO()->getTiempoEntreFechas($fecha_fin);
	printf("tiempo dedicado: %s </br>",$tiempo_decicado);
	
	//finally
	$this->registry->template->show('reportes/profesor');
	
}

//cgajardo: función para probar el handler de google chart
public function ensayo(){							
										
	$this->registry->template->show('reportes/ensayo');
}

//cgajardo: función mostrar el tiempo que pasa un alumno entre dos fechas
public function tiempo(){
	$tiempo = DAOFactory::getLogsDAO()->getTiempoEntreFechas('1970-01-01 12:00:00','2012-01-01 12:00:00', 843);
	$this->registry->template->tiempo = round($tiempo/60); 
	$this->registry->template->show('reportes/tiempo');
}

}
?>
