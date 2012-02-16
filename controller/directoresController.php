<?php
/**
* Este controlador se encargará de mostrar los reportes para directores
*  
* */
Class directoresController Extends baseController {

public function index(){
	session_start(); //inicia una sesion
	$id_director = $_GET['id'];
	$director = DAOFactory::getPersonasDAO()->load($id_director);
	//buscamos la institución en la session
	if(isset($_SESSION['institucion'])){
		$institucion = $_SESSION['institucion'];
	}else{
		$institucion = DAOFactory::getInstitucionesDAO()->getInstitucionByDirectorId($director->id);
	}
	
	$this->registry->template->usuario = $director;
	$this->registry->template->institucion = $institucion;
	$this->registry->template->show('director/index');
}

public function tiempo(){
	session_start(); //inicia una sesion
	$id_director = $_GET['id'];
	$director = DAOFactory::getPersonasDAO()->load($id_director);
	$sedes = DAOFactory::getSedesDAO()->getSedesByDirector($director->id);
	
	//buscamos la institución en la session
	if(isset($_SESSION['institucion'])){
		$institucion = $_SESSION['institucion'];
	}else{
		$institucion = DAOFactory::getInstitucionesDAO()->getInstitucionByDirectorId($director->id);
	}
	
	/* árbol de tiempo para una institución */
	$arbol_tiempo = array();
	$suma_tiempo_sedes = 0;
	$suma_alumnos_sedes = 0;
	foreach ($sedes as $sede){
		$cursos = DAOFactory::getCursosDAO()->getCursosInSede($sede->id);
		$suma_tiempo_cursos = 0;
		$suma_alumnos_cursos = 0;
		//buscamos todos los cursos en una sede
		foreach ($cursos as $curso){
			$grupos = DAOFactory::getGruposDAO()->getGruposInCurso($curso->id);
			$suma_tiempo_grupos = 0;
			$suma_alumnos_grupos = 0;
			//buscamos todos todos grupos en un curso
			foreach ($grupos as $grupo){
				$alumnos = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
				$suma_tiempo_alumnos = 0;
				$suma_alumnos = 0;
				//buscamos todos los alumnos de un grupo (sumamos su tiempo)
				foreach ($alumnos as $alumno){
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->nombre.', '.$alumno->apellido]['nombre'] = $alumno->nombre.' '.$alumno->apellido;
					//desde el inicio de los tiempos hasta hoy
					$tiempo = DAOFactory::getLogsDAO()->getTiempoEntreFechas(0, time(), $alumno->id);
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->nombre.', '.$alumno->apellido]['tiempo'] = $tiempo;
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->nombre.', '.$alumno->apellido]['alumnos'] = 1;
					$suma_tiempo_alumnos += $tiempo;
					$suma_alumnos++;
				}
				$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['tiempo'] = $suma_tiempo_alumnos;
				$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['alumnos'] = $suma_alumnos;
				$suma_tiempo_grupos += $suma_tiempo_alumnos;
				$suma_alumnos_grupos += $suma_alumnos;
			}
			$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['tiempo'] = $suma_tiempo_grupos;
			$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['alumnos'] = $suma_alumnos_grupos;
			$suma_tiempo_cursos += $suma_tiempo_grupos;
			$suma_alumnos_cursos += $suma_alumnos_grupos;
		}
		$arbol_tiempo['detalle'][$sede->nombre]['tiempo'] = $suma_tiempo_cursos;
		$arbol_tiempo['detalle'][$sede->nombre]['alumnos'] = $suma_alumnos_cursos;
		$suma_tiempo_sedes += $suma_tiempo_cursos;
		$suma_alumnos_sedes += $suma_alumnos_cursos;
	}
	$arbol_tiempo['tiempo'] = $suma_tiempo_sedes;
	$arbol_tiempo['alumnos'] = $suma_alumnos_sedes;
	
	//TODO: deberia serializar? costo/efectividad...
	$_SESSION['arbolTiempo'] = $arbol_tiempo;
	
	//FIX
	$cadena = '[';
	foreach ($arbol_tiempo['detalle'] as $nombre => $nodo){
		$cadena .= '["'.$nombre.'",'.round($nodo['tiempo']/60/$nodo['alumnos']).'],';
	}
	
	$this->registry->template->institucion = $institucion;
	$this->registry->template->arbol = substr($cadena, 0, -1).']';
	$this->registry->template->director = $director;
	$this->registry->template->sedes = $sedes;
	$this->registry->template->titulo = 'Informe para directores';
	$this->registry->template->show('director/tiempo');
}

/** esta funcion es la encargada de mostrar el detalle de tiempo para un alumno en la vista del director **/
public function matriz(){
	$director = utf8_decode($_GET['director']);
	$nombre_sede = utf8_decode($_GET['sede']);
	$nombre_curso = utf8_decode($_GET['curso']);
	$nombre_grupo = utf8_decode($_GET['grupo']);
	$nombre_alumno = utf8_decode($_GET['alumno']);
	 
	// esto es lo necesario para la matriz de desempeño, TODO: debería tener su vista propia?
// 	$matriz_desempeño = array();
// 	$quizes_en_curso = DAOFactory::getQuizesDAO()->queryCerradosByIdCurso($curso->id);

// 	foreach ($quizes_en_curso as $quiz_en_curso){
// 		$logro_contenido = DAOFactory::getIntentosDAO()->getLogroPorContenido($quiz_en_curso->id, $usuario->id);
// 		if(empty($logro_contenido)){
// 			$matriz_desempeño[$quiz_en_curso->nombre] = DAOFactory::getContenidosDAO()->getContenidosByQuiz($quiz_en_curso->id);
// 		}else{
// 			$matriz_desempeño[$quiz_en_curso->nombre] = $logro_contenido;
// 		}
// 	}
	$usuario = DAOFactory::getPersonasDAO()->getPersonaByNombreGrupo($nombre_alumno, $nombre_grupo);
	//calculamos el tiempo que paso el usuario entre quizes
	//$inicio = '1970-01-01 12:00:00';
	//hoy será hace 1 mes atrás
	$hoy = time();
	$semana_pasada = $hoy - (7 * 24 * 60 * 60);
	$tiempos_semanas = array();
	for ($i = 0; $i<15; $i++){
		$tiempos_semanas[ date("d/m",$semana_pasada)] = DAOFactory::getLogsDAO()->getTiempoEntreFechas($semana_pasada,$hoy, $usuario->id);
		$hoy = $semana_pasada;
		$semana_pasada = $hoy - (7 * 24 * 60 * 60);
	}
	
	//enviamos los siguientes valores a la vista
	$this->registry->template->tiempos_semanas = $tiempos_semanas;
	
	//finally
	$this->registry->template->show('director/detalle_tiempo');
}


public function logro(){
	session_start(); //inicia una sesion
	$id_director = $_GET['id'];
	$director = DAOFactory::getPersonasDAO()->load($id_director);
	$sedes = DAOFactory::getSedesDAO()->getSedesByDirector($director->id);
	
	//buscamos la institución en la session
	if(isset($_SESSION['institucion'])){
		$institucion = $_SESSION['institucion'];
	}else{
		$institucion = DAOFactory::getInstitucionesDAO()->getInstitucionByDirectorId($director->id);
	}
	
	/* árbol de tiempo para una institución */
	$arbol_logro = array();
	$suma_tiempo_sedes = 0;
	$suma_alumnos_sedes = 0;
	foreach ($sedes as $sede){
		$cursos = DAOFactory::getCursosDAO()->getCursosInSede($sede->id);
		$suma_tiempo_cursos = 0;
		$suma_alumnos_cursos = 0;
		//buscamos todos los cursos en una sede
		foreach ($cursos as $curso){
			$grupos = DAOFactory::getGruposDAO()->getGruposInCurso($curso->id);
			$suma_tiempo_grupos = 0;
			$suma_alumnos_grupos = 0;
			//buscamos todos todos grupos en un curso
			foreach ($grupos as $grupo){
				$alumnos = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
				$suma_tiempo_alumnos = 0;
				$suma_alumnos = 0;
				//buscamos todos los alumnos de un grupo (sumamos su tiempo)
				foreach ($alumnos as $alumno){
					$arbol_logro['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->nombre.', '.$alumno->apellido]['nombre'] = $alumno->nombre.' '.$alumno->apellido;
					//desde el inicio de los tiempos hasta hoy
					$logros = DAOFactory::getIntentosDAO()->getLogroPorQuiz($alumno->id);
					$cantidad_quizes = 0;
					$suma_logro = 0;
					foreach ($logros as $logro){
						$arbol_logro['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->nombre.', '.$alumno->apellido]['actividades'][$logro['quiz']] = $logro['logro'];
						$cantidad_quizes++;
						$suma_logro += $logro['logro'];
					}
					$arbol_logro['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->nombre.', '.$alumno->apellido]['promedio'] = round($suma_logro/$cantidad_quizes);
					$suma_tiempo_alumnos += round($suma_logro/$cantidad_quizes);
					$suma_alumnos++;
				}
				$arbol_logro['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['promedio'] = $suma_tiempo_alumnos/$suma_alumnos;
				$suma_tiempo_grupos += $suma_tiempo_alumnos;
				$suma_alumnos_grupos += $suma_alumnos;
			}
			$arbol_logro['detalle'][$sede->nombre]['detalle'][$curso->nombre]['promedio'] = $suma_tiempo_grupos/$suma_alumnos_grupos;
			$suma_tiempo_cursos += $suma_tiempo_grupos;
			$suma_alumnos_cursos += $suma_alumnos_grupos;
		}
		$arbol_logro['detalle'][$sede->nombre]['promedio'] = $suma_tiempo_cursos/$suma_alumnos_cursos;
		$suma_tiempo_sedes += $suma_tiempo_cursos;
		$suma_alumnos_sedes += $suma_alumnos_cursos;
	}
	$arbol_logro['promedio'] = $suma_tiempo_sedes/$suma_alumnos_sedes;
	
	//TODO: deberia serializar? costo/efectividad...
	$_SESSION['arbolTiempo'] = $arbol_logro;

	$cadena = '[';
	foreach ($arbol_logro['detalle'] as $nombre => $nodo){
		$cadena .= '["'.$nombre.'",'.round($nodo['promedio'],1).'],';
	}

	$this->registry->template->institucion = $institucion;
	$this->registry->template->arbol = substr($cadena, 0, -1).']';
	$this->registry->template->director = $director;
	$this->registry->template->titulo = 'Informe para directores';
	$this->registry->template->show('director/logro');
}

public function data(){
	session_start(); //reinicia la sesion
	$arbol_tiempo = array();

	if(isset($_GET['grupo'])){
		/* árbol de tiempo para un curso */
		$id_director = utf8_decode($_GET['director']);
		$nombre_sede = utf8_decode($_GET['sede']);
		$nombre_curso = utf8_decode($_GET['curso']);
		$nombre_grupo =  utf8_decode($_GET['grupo']);
		if(isset($_SESSION['arbolTiempo'])){
			$arbolCompleto = $_SESSION['arbolTiempo'];
			$arbol_tiempo = $arbolCompleto['detalle'][$nombre_sede]['detalle'][$nombre_curso]['detalle'][$nombre_grupo];
		}

	}//termina el if

	elseif(isset($_GET['curso'])){
		/* árbol de tiempo para un curso */
		$id_director = utf8_decode($_GET['director']);
		$nombre_sede = utf8_decode($_GET['sede']);
		$nombre_curso = utf8_decode($_GET['curso']);

		if(isset($_SESSION['arbolTiempo'])){
			$arbolCompleto = $_SESSION['arbolTiempo'];
			$arbol_tiempo = $arbolCompleto['detalle'][$nombre_sede]['detalle'][$nombre_curso];
		}
	}//termina el if

	elseif(isset($_GET['sede'])){
		/* árbol de tiempo para una sede */
		$id_director = utf8_decode($_GET['director']);
		$nombre_sede = utf8_decode($_GET['sede']);

		if(isset($_SESSION['arbolTiempo'])){
			$arbolCompleto = $_SESSION['arbolTiempo'];
			$arbol_tiempo = $arbolCompleto['detalle'][$nombre_sede];
		}
	}//termina el if

	$this->registry->template->arbol = $arbol_tiempo;
	$this->registry->template->show('director/json');
}

public function dataLogro(){
	session_start(); //reinicia la sesion
	$arbol_tiempo = array();

	if(isset($_GET['grupo'])){
		/* árbol de tiempo para un curso */
		$id_director = utf8_decode($_GET['director']);
		$nombre_sede = utf8_decode($_GET['sede']);
		$nombre_curso = utf8_decode($_GET['curso']);
		$nombre_grupo =  utf8_decode($_GET['grupo']);
		if(isset($_SESSION['arbolTiempo'])){
			$arbolCompleto = $_SESSION['arbolTiempo'];
			$arbol_tiempo = $arbolCompleto['detalle'][$nombre_sede]['detalle'][$nombre_curso]['detalle'][$nombre_grupo];
		}

	}//termina el if

	elseif(isset($_GET['curso'])){
		/* árbol de tiempo para un curso */
		$id_director = utf8_decode($_GET['director']);
		$nombre_sede = utf8_decode($_GET['sede']);
		$nombre_curso = utf8_decode($_GET['curso']);

		if(isset($_SESSION['arbolTiempo'])){
			$arbolCompleto = $_SESSION['arbolTiempo'];
			$arbol_tiempo = $arbolCompleto['detalle'][$nombre_sede]['detalle'][$nombre_curso];
		}
	}//termina el if

	elseif(isset($_GET['sede'])){
		/* árbol de tiempo para una sede */
		$id_director = utf8_decode($_GET['director']);
		$nombre_sede = utf8_decode($_GET['sede']);

		if(isset($_SESSION['arbolTiempo'])){
			$arbolCompleto = $_SESSION['arbolTiempo'];
			$arbol_tiempo = $arbolCompleto['detalle'][$nombre_sede];
		}
	}//termina el if

	$this->registry->template->arbol = $arbol_tiempo;
	$this->registry->template->show('director/jsonLogro');
}


public function matrizLogro(){

	$director = utf8_decode($_GET['director']);
	$nombre_sede = utf8_decode($_GET['sede']);
	$nombre_curso = utf8_decode($_GET['curso']);
	$nombre_grupo = utf8_decode($_GET['grupo']);
	$nombre_alumno = utf8_decode($_GET['alumno']);

	$usuario = DAOFactory::getPersonasDAO()->getPersonaByNombreGrupo($nombre_alumno, $nombre_grupo);
	$curso = DAOFactory::getCursosDAO()->getCursosByUsuarioAndNombre($usuario->id, $nombre_curso);
	
	//esto es lo necesario para la matriz de desempeño, TODO: debería tener su vista propia?
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
	$this->registry->template->matriz_desempeño = $matriz_desempeño; 
	//finally
	
	$this->registry->template->show('director/detalle_logro');
}

public function view(){
	/*** should not have to call this here.... FIX ME ***/
	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

}
?>
