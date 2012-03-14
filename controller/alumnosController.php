<?php

Class alumnosController Extends baseController {

public function index() {
	session_start();
	@$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	
	$usuario = $_SESSION['usuario'];
	$platform = $_SESSION['plataforma'];
	$cursos_usuarios = DAOFactory::getCursosDAO()->getCursosByUsuario($usuario->id);
	$institucion = DAOFactory::getInstitucionesDAO()->load($usuario->idInstitucion);
	$this->registry->template->institucion = $institucion;
	
	// redireccionamos al 404 si usuario no existe
	if($usuario == null){
		$this->registry->template->mesaje_personalizado = "Debes ser un usuario de Galyleo para visitar esta p&aacute;gina.</br>".
				"Si tu cuenta fue creada recientemente debes esperar un par de minutos a que nuestros sistemas se actualicen.";
		//finally
		$this->registry->template->show('error404');
		return;
	}
	// o si no tiene cursos asociados
	elseif ($cursos_usuarios == null){
		$this->registry->template->mesaje_personalizado = "Tu cuenta no est&aacute; asociada a ning&uacute;n curso.</br>".
				"Probablemente llegaste hasta ac&aacute; por error.";
		//finally
		$this->registry->template->show('error404');
		return;
	}
	
	/* caso en que el usuario ya selecciono el curso*/
	elseif (isset($PARAMS['curso'])){
		$id_curso = $PARAMS['curso'];
		
        //        $actividades = DAOFactory::getCursosHasContenidos()->getCerradosByCursoWithContenidos($id_curso);
		$quizes = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($id_curso);
        //        $actividades_actual=  DAOFactory::getCursosHasContenidos()->getActuales($id_curso);
               
		$this->registry->template->titulo = 'Tus evaluaciones';
		$this->registry->template->usuario = $usuario;
		$this->registry->template->cursos = $cursos_usuarios;
		$this->registry->template->encrypter = $this->encrypter;
		$this->registry->template->quizes = $quizes;
		$this->registry->template->id_curso = $id_curso;
		//$this->registry->template->calendario = $actividades;
		//$this->registry->template->actividades_actual = $actividades_actual;
		//finally
		$this->registry->template->show('alumnos/index_quizes');
		return;
	}
	
	$this->registry->template->titulo = 'Tus cursos';
	$this->registry->template->usuario = $usuario;
	$this->registry->template->cursos = $cursos_usuarios;
	$this->registry->template->encrypter = $this->encrypter;
    //finally
    $this->registry->template->show('alumnos/index_cursos');
}

public function reporte(){
	session_start();
	$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	$curso_id = $PARAMS['curso'];
	$quiz_id = $PARAMS['quiz'];

	//recuperamos los objetos que nos interesan
	$usuario = $_SESSION['usuario'];
	
	$rol = $usuario->getRol(); 
	if( $rol == 'rector' || $rol == 'profesor'){
		$curso_id = $_GET['curso'];
		$quiz_id = $_GET['quiz'];
		$nombreApellido = explode(',', $_GET['alumno']);
		$nombre = trim($nombreApellido[1]);
		$apellido = trim($nombreApellido[0]);
		$usuario = DAOFactory::getPersonasDAO()->queryByNombreApellido($nombre,$apellido);
	}
	
	$platform = $_SESSION['plataforma'];
	
	//permite a un profesor o director ver el reporte de un alumno
	if(isset($PARAMS['usuario'])){
		$usuario = DAOFactory::getPersonasDAO()->load($PARAMS['usuario']);
	}
	
	$curso = DAOFactory::getCursosDAO()->load($curso_id);
	$quiz = DAOFactory::getQuizesDAO()->load($quiz_id);

	$institucion = DAOFactory::getInstitucionesDAO()->getInstitucionByAlumno($usuario->id);
	$grupo = DAOFactory::getGruposDAO()->getGrupoByCursoAndUser($usuario->id, $curso->id);
	$estudiantes_en_grupo = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
	$notas_grupo = DAOFactory::getIntentosDAO()->getNotasGrupo($quiz->id,$grupo->id);
	$nota_alumno = DAOFactory::getIntentosDAO()->getNotaInQuizByPersona($quiz->id, $usuario->id);
	$contenido_logro = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz->id, $usuario->id);
	
	// esto es lo necesario para la matriz de desempeño, TODO: debería tener su vista propia?
	$matriz_desempeño = array();
	$quizes_en_curso = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($curso->id);
	foreach ($quizes_en_curso as $quiz_en_curso){
		$logro_contenido = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz_en_curso->id, $usuario->id);
		if(empty($logro_contenido)){
			$matriz_desempeño[$quiz_en_curso->nombre] = DAOFactory::getContenidosDAO()->getContenidosByQuiz($quiz_en_curso->id);
		}else{
			$matriz_desempeño[$quiz_en_curso->nombre] = $logro_contenido;
		}
	}
	$tiempos_semanas = array();
	$thisMonday = time() - (date('w')-1)*60*60*24;
	$hoy = time();
	//el tiempo de esta semana
	$tiempos_semanas[ date("d/m",$thisMonday)] = DAOFactory::getLogsDAO()->getTiempoEntreFechas($thisMonday,$hoy, $usuario->id);
	$semana_pasada = $thisMonday - (7 * 24 * 60 * 60);
	$hoy = $thisMonday; 
	for ($i = 0; $i<9; $i++){
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
	$this->registry->template->porcentaje_aprobado = ($institucion->notaAprobado-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->porcentaje_suficiente = ($institucion->notaSuficiente-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->institucion = $institucion;
	$this->registry->template->matriz_desempeño = $matriz_desempeño;
	$this->registry->template->tiempos_semanas = $tiempos_semanas;


	//finally
	$this->registry->template->show('alumnos/reporte');

}

public function nivelacion(){
    
    session_start();
	$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	$curso_id = $PARAMS['curso'];

	//recuperamos los objetos que nos interesan
	$usuario = $_SESSION['usuario'];
	$platform = $_SESSION['plataforma'];
	
	//permite a un profesor o director ver el reporte de un alumno
	if(isset($PARAMS['usuario'])){
		$usuario = DAOFactory::getPersonasDAO()->load($PARAMS['usuario']);
	}
	
	$curso = DAOFactory::getCursosDAO()->load($curso_id);

	$institucion = DAOFactory::getInstitucionesDAO()-> getInstitucionByNombrePlataforma($platform);
	$grupo = DAOFactory::getGruposDAO()->getGrupoByCursoAndUser($usuario->id, $curso->id);
        $quiz = DAOFactory::getQuizesDAO()->queryDiagnosticosByIdCurso($curso->id);
        foreach(DAOFactory::getIntentosDAO()->getLogroPorContenidoWithPadre($quiz->id, $usuario->id) as $contenido){
            $contenido_logro[$contenido['contenido']->padre][$contenido['contenido']->nombre]=$contenido['logro'];
        }
        $notas_curso=  DAOFactory::getIntentosDAO()->getNotasCurso($quiz->id,$curso->id);
        $estudiantes_en_curso = 0;
        foreach(DAOFactory::getGruposDAO()->getGruposInCurso($curso->id) as $grupo){
            $estudiantes_en_curso +=count(DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id));
        }
        $this->registry->template->contenido_logro = $contenido_logro;
	$nota_alumno = DAOFactory::getIntentosDAO()->getNotaInQuizByPersona($quiz->id, $usuario->id);
        
	

	//enviamos los siguientes valores a la vista*/
	$this->registry->template->titulo = 'Reporte Estudiante';
	$this->registry->template->usuario = $usuario;
	$this->registry->template->notas_curso = $notas_curso;
	$this->registry->template->logro_curso = (promedio_grupo($notas_curso,$estudiantes_en_curso)-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->nota_alumno = $nota_alumno[0];
	$this->registry->template->posicion_en_curso = posicion($notas_curso, $nota_alumno[0]);
	$this->registry->template->total_estudiantes_curso = count($estudiantes_en_curso);
	$this->registry->template->nombre_actividad = 'Nivelacion';
	//$this->registry->template->fecha_cierre = $quiz->fechaCierre;
	//$this->registry->template->contenido_logro = $contenido_logro;
        $this->registry->template->porcentaje_aprobado = ($institucion->notaAprobado-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->porcentaje_suficiente = ($institucion->notaSuficiente-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->nombre_curso = $curso->nombre;
	$this->registry->template->nombre_grupo = $grupo->nombre;
	$this->registry->template->institucion = $institucion;
	//$this->registry->template->matriz_desempeño = $matriz_desempeño;
	//$this->registry->template->tiempos_semanas = $tiempos_semanas;

        
	//finally
	$this->registry->template->show('alumnos/nivelacion');
}

public function avance(){
    
        session_start();
	$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	$curso_id = $PARAMS['curso'];

		//recuperamos los objetos que nos interesan
	$usuario = $_SESSION['usuario'];
	$platform = $_SESSION['plataforma'];
	
	//permite a un profesor o director ver el reporte de un alumno
	if(isset($PARAMS['usuario'])){
		$usuario = DAOFactory::getPersonasDAO()->load($PARAMS['usuario']);
	}
	
	$curso = DAOFactory::getCursosDAO()->load($curso_id);

	$institucion = DAOFactory::getInstitucionesDAO()-> getInstitucionByNombrePlataforma($platform);
	$grupo = DAOFactory::getGruposDAO()->getGrupoByCursoAndUser($usuario->id, $curso->id);
        $quiz = DAOFactory::getQuizesDAO()->queryDiagnosticosByIdCurso($curso->id);
        foreach(DAOFactory::getIntentosDAO()->getLogroPorContenidoWithPadre($quiz->id, $usuario->id) as $contenido){
            $contenido_logro[$contenido['contenido']->padre][$contenido['contenido']->nombre]=$contenido['logro'];
        }
        $notas_curso=  DAOFactory::getIntentosDAO()->getNotasCurso($quiz->id,$curso->id);
        $estudiantes_en_curso = 0;
        foreach(DAOFactory::getGruposDAO()->getGruposInCurso($curso->id) as $grupo){
            $estudiantes_en_curso +=count(DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id));
        }
        $this->registry->template->contenido_logro = $contenido_logro;
	$nota_alumno = DAOFactory::getIntentosDAO()->getNotaInQuizByPersona($quiz->id, $usuario->id);
        
	

	//enviamos los siguientes valores a la vista*/
	$this->registry->template->titulo = 'Reporte Estudiante';
	$this->registry->template->usuario = $usuario;
	$this->registry->template->notas_curso = $notas_curso;
	$this->registry->template->logro_curso = (promedio_grupo($notas_curso,$estudiantes_en_curso)-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->nota_alumno = $nota_alumno[0];
	$this->registry->template->posicion_en_curso = posicion($notas_curso, $nota_alumno[0]);
	$this->registry->template->total_estudiantes_curso = count($estudiantes_en_curso);
	$this->registry->template->nombre_actividad = 'Nivelacion';
	//$this->registry->template->fecha_cierre = $quiz->fechaCierre;
	//$this->registry->template->contenido_logro = $contenido_logro;
        $this->registry->template->porcentaje_aprobado = ($institucion->notaAprobado-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->porcentaje_suficiente = ($institucion->notaSuficiente-$quiz->notaMinima)/($quiz->notaMaxima-$quiz->notaMinima)*100;
	$this->registry->template->nombre_curso = $curso->nombre;
	$this->registry->template->nombre_grupo = $grupo->nombre;
	$this->registry->template->institucion = $institucion;
	//$this->registry->template->matriz_desempeño = $matriz_desempeño;
	//$this->registry->template->tiempos_semanas = $tiempos_semanas;

        
	//finally
	$this->registry->template->show('alumnos/nivelacion');
}

}
?>
