<?php

Class reportesController Extends baseController {

public function index() 
{
    //TODO: quï¿½ hace en el index?
    $user_id_in_moodle = $_GET['user'];
    $platform = $_GET['platform'];
    $usuario = DAOFactory::getPersonasDAO()->getUserInPlatform($platform,$user_id_in_moodle);
    $this->registry->template->reporte_main = 'se deber&iacute;an listar todos los reportes';
    $this->registry->template->nombre_usuario = $usuario->nombre;
    $this->registry->template->apellido_usuario = $usuario->apellido;
    $this->registry->template->intentos = DAOFactory::getIntentosDAO()->getIntentosByUsuario($usuario->id);
    $this->registry->template->quizes = DAOFactory::getQuizesDAO()->getQuizesByUsuario($usuario->id);
    
    //finally
    $this->registry->template->show('reportes/index');
}

/* esta funciï¿½n es solo un ejemplo del uso de Google Chart */
public function semanal(){
	$user_id_in_moodle = $_GET['user'];
	$platform = $_GET['platform'];
	$grupo_id_in_moodle = $_GET['group'];
	$quiz_id_in_moodle = $_GET['quiz'];
	
	//recuperamos los objetos que nos interesan
	$usuario = DAOFactory::getPersonasDAO()->getUserInPlatform($platform,$user_id_in_moodle);
	$grupo = DAOFactory::getGruposDAO()->getGrupoByIdEnMoodle($platform,$grupo_id_in_moodle);
	$curso = DAOFactory::getCursosDAO()->getCursoByGrupoId($grupo->id);
	$estudiantes_en_grupo = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
	$quiz = DAOFactory::getQuizesDAO()->getGalyleoQuizByMoodleId($platform, $quiz_id_in_moodle);
	$notas_grupo = DAOFactory::getIntentosDAO()->getNotasGrupo($quiz->id,$grupo->id);
	$nota_alumno = DAOFactory::getIntentosDAO()->getNotaInQuizByPersona($quiz->id, $usuario->id);
	$contenido_logro = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz->id, $usuario->id);
	
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
	
	// esto es lo necesario para la matriz de desempe–o, TODO: deber’a tener su vista propia?
	$quizes_en_curso = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($curso->id);
	$matriz_desempe–o = array();
	foreach ($quizes_en_curso as $quiz_en_curso){
		$matriz_desempe–o[$quiz_en_curso->nombre] = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz_en_curso->id, $usuario->id);
	}
	
	//enviamos estos elementos a la vista
	$this->registry->template->matriz_desempe–o = $matriz_desempe–o;
	
	//tiempo dedicado frente a cada quiz
	$tiempo_decicado = DAOFactory::getLogsDAO()->getTiempoEntreFechas($fecha_fin);
	printf("tiempo dedicado: %s </br>",$tiempo_decicado);
	
	//finally
	$this->registry->template->show('reportes/semanal');
	
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
	
	// esto es lo necesario para la matriz de desempeï¿½o, TODO: deberï¿½a tener su vista propia?
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

public function view(){																

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

}
?>
