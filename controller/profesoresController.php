<?php

Class profesoresController Extends baseController {

public function index() 
{
        $this->registry->template->blog_heading = 'This is the blog Index';
        $this->registry->template->show('blog_index');
}


public function view(){

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

public function reporte(){
	//print $this->encrypter->encode("plataforma=utfsm&usuario=1104&grupo=24&quiz=71")."</br>";
	print $this->encrypter->encode("platform=utfsm&user=618")."</br>";

	$PARAMS = $this->encrypter->decodeURL($_GET['params']);

	//$PARAMS=$_GET;
	if(isset($PARAMS['platform'])){
		$user_id_in_moodle = $PARAMS['user'];
		$platform = $PARAMS['platform'];
		$grupo_id_in_moodle=$PARAMS['group'];
		$grupo = DAOFactory::getGruposDAO()->getGrupoByIdEnMoodle($platform,$grupo_id_in_moodle);
		$quiz_id_in_moodle = $PARAMS['quiz'];

		//recuperamos los objetos que nos interesan
		$usuario = DAOFactory::getPersonasDAO()->getUserInPlatform($platform,$user_id_in_moodle);
		$quiz = DAOFactory::getQuizesDAO()->getGalyleoQuizByMoodleId($platform, $quiz_id_in_moodle);

	}
	elseif(isset($PARAMS['plataforma'])){
		$user_id = $PARAMS['usuario'];
		$platform = $PARAMS['plataforma'];
		$grupo_id=$PARAMS['grupo'];
		$quiz_id = $PARAMS['quiz'];

		//recuperamos los objetos que nos interesan
		$grupo = DAOFactory::getGruposDAO()->load($grupo_id);
		$usuario = DAOFactory::getPersonasDAO()->load($user_id);
		$quiz = DAOFactory::getQuizesDAO()->load($quiz_id);
	}
	if(DAOFactory::getGruposHasProfesoresDAO()->load($user_id,$grupo_id)==NULL){
		$this->registry->template->mesaje_personalizado="<h1>Usted no es Profesor</h1>";
		$this->registry->template->show('error404');
		return;

	}

	session_start();
	//recuperamos los objetos que nos interesan
	$institucion = DAOFactory::getInstitucionesDAO()-> getInstitucionByNombrePlataforma($platform);
	$curso = DAOFactory::getCursosDAO()->getCursoByGrupoId($grupo->id);
	$estudiantes_en_grupo = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
	$notas_grupo = DAOFactory::getIntentosDAO()->getNotasNombreGrupo($quiz->id,$grupo->id);
	$contenido_logro = DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupo($quiz->id);
	//$nota_maxima= DAOFactory::getNotasDAO()->getMaxNotaInQuiz($quiz->id);

	//enviamos los siguientes valores a la vista
	$this->registry->template->titulo = 'Reporte Profesor';
	$_SESSION['usuario'] = $usuario;
	$_SESSION['curso'] = $curso;
	$_SESSION['grupo'] = $grupo;
	$_SESSION['platform'] = $platform;
	$_SESSION['notas_grupo'] = $notas_grupo;
	$_SESSION['nota_maxima'] = 100;
	$_SESSION['promedio_grupo'] = promedio_grupo($notas_grupo,count($estudiantes_en_grupo));
	$_SESSION['quiz']=$quiz;
	$this->registry->template->estudiantes =$estudiantes_en_grupo;
	$this->registry->template->total_estudiantes_grupo = count($estudiantes_en_grupo);
	$_SESSION['nombre_actividad'] = $quiz->nombre;
	$this->registry->template->fecha_cierre = $quiz->fechaCierre;
	$this->registry->template->contenido_logro = $contenido_logro;
	$this->registry->template->nombre_curso = $curso->nombre;
	$this->registry->template->nombre_grupo = $grupo->nombre;
	$this->registry->template->institucion = $institucion;

	// esto es lo necesario para la matriz de desempeño, TODO: deber�a tener su vista propia?
	$quizes_en_curso = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($curso->id);
	$matriz_desempeno = array();
	foreach ($quizes_en_curso as $quiz_en_curso){
		$contenidos=DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupo($quiz_en_curso->id);
		$matriz_desempeno[$quiz_en_curso->nombre] = DAOFactory::getIntentosDAO()->getPromedioLogroPorContenido($quiz_en_curso->id, $grupo->id);
	}
	$matriz_contenidos = array();
	foreach($matriz_desempeno[$quiz->nombre] as $contenido){
		$matriz_contenidos[$contenido['contenido']->nombre] = DAOFactory::getIntentosDAO()->getLogroPorContenido2($grupo->id, $quiz->id, $contenido['contenido']->id);
	}

	$tiempo = DAOFactory::getLogsDAO()->getTiempoTarea($quiz->fechaCierre, $grupo->id);
	//enviamos estos elementos a la vista
	$_SESSION['matriz_desempeño'] = $matriz_desempeno;
	$_SESSION['matriz_contenidos'] = $matriz_contenidos;
	$_SESSION['tiempos'] = $tiempo;
	//tiempo dedicado frente a cada quiz

	//finally
	$this->registry->template->show('profesor/reporte');
}

public function quiz_profesor(){
	//print $this->encrypter->encode("plataforma=utfsm&usuario=1104&grupo=24&quiz=71")."</br>";
	//$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	session_start();

	$platform = $_SESSION['platform'];
	$usuario = $_SESSION['usuario'];
	$grupo = $_SESSION['grupo'];
	$quiz = $_SESSION['quiz'];
	if(DAOFactory::getGruposHasProfesoresDAO()->load($usuario->id,$grupo->id)==NULL){
		$this->registry->template->mesaje_personalizado="<h1>Usted no es Profesor</h1>";
		$this->registry->template->show('error404');
		return;

	}

	//recuperamos los objetos que nos interesan
	$institucion = DAOFactory::getInstitucionesDAO()-> getInstitucionByNombrePlataforma($platform);
	$curso = DAOFactory::getCursosDAO()->getCursoByGrupoId($grupo->id);
	$estudiantes_en_grupo = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
	$notas_grupo = DAOFactory::getIntentosDAO()->getNotasNombreGrupo($quiz->id,$grupo->id);
	$contenido_logro = DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupo($quiz->id);
	//$nota_maxima= DAOFactory::getNotasDAO()->getMaxNotaInQuiz($quiz->id);

	//enviamos los siguientes valores a la vista
	$this->registry->template->titulo = 'Reporte Profesor';
	$_SESSION['usuario'] = $usuario;
	$_SESSION['notas_grupo'] = $notas_grupo;
	$_SESSION['nota_maxima'] = 100;
	$_SESSION['promedio_grupo'] = promedio_grupo($notas_grupo,count($estudiantes_en_grupo));
	$this->registry->template->estudiantes =$estudiantes_en_grupo;
	$this->registry->template->total_estudiantes_grupo = count($estudiantes_en_grupo);
	$_SESSION['nombre_actividad'] = $quiz->nombre;
	$this->registry->template->fecha_cierre = $quiz->fechaCierre;
	$this->registry->template->contenido_logro = $contenido_logro;
	$this->registry->template->nombre_curso = $curso->nombre;
	$this->registry->template->nombre_grupo = $grupo->nombre;
	$this->registry->template->institucion = $institucion;

	// esto es lo necesario para la matriz de desempeño, TODO: deber�a tener su vista propia?
	$quizes_en_curso = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($curso->id);
	$matriz_desempeno = array();
	foreach ($quizes_en_curso as $quiz_en_curso){
		$contenidos=DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupo($quiz_en_curso->id);
		$matriz_desempeno[$quiz_en_curso->nombre] = DAOFactory::getIntentosDAO()->getPromedioLogroPorContenido($quiz_en_curso->id, $grupo->id);
	}
	$matriz_contenidos = array();
	foreach($matriz_desempeno[$quiz->nombre] as $contenido){
		$matriz_contenidos[$contenido['contenido']->nombre] = DAOFactory::getIntentosDAO()->getLogroPorContenido2($grupo->id, $quiz->id, $contenido['contenido']->id);
	}

	$tiempo = DAOFactory::getLogsDAO()->getTiempoTarea($quiz->fechaCierre, $grupo->id);
	//enviamos estos elementos a la vista
	$_SESSION['matriz_desempeño'] = $matriz_desempeno;
	$_SESSION['matriz_contenidos'] = $matriz_contenidos;
	$_SESSION['tiempos'] = $tiempo;

	$this->registry->template->show('profesor/quiz_profesor');

}

}
?>
