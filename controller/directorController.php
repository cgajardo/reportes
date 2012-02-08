<?php
/**
* Este controlador se encargará de mostrar los reportes para directores
*  
* */
Class directorController Extends baseController {


public function index() {
	session_start(); //inicia una sesion
	$id_director = $_GET['id'];
	$director = DAOFactory::getPersonasDAO()->load($id_director);
	$sedes = DAOFactory::getSedesDAO()->getSedesByDirector($director->id);
	
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
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->id]['nombre'] = $alumno->nombre.' '.$alumno->apellido;
					//desde el inicio de los tiempos hasta hoy
					$tiempo = DAOFactory::getLogsDAO()->getTiempoEntreFechas(0, time(), $alumno->id);
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->id]['tiempo'] = $tiempo;
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->id]['alumnos'] = 1;
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
		$cadena .= '["'.$nombre.'",'.($nodo['tiempo']/60/$nodo['alumnos']).'],';
	}
	
	$this->registry->template->arbol = substr($cadena, 0, -1).']';
	$this->registry->template->director = $director;
	$this->registry->template->sedes = $sedes;
	$this->registry->template->show('director/index');
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

public function view(){
	/*** should not have to call this here.... FIX ME ***/
	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

}
?>
