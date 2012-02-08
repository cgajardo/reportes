<?php
/**
* Este controlador se encargará de mostrar los reportes para directores
*  
* */
Class directorController Extends baseController {


public function index() {
	$id_director = $_GET['id'];
	$director = DAOFactory::getPersonasDAO()->load($id_director);
	$sedes = DAOFactory::getSedesDAO()->getSedesByDirector($director->id);
	
	/* árbol de tiempo para una institución */
	$arbol_tiempo = array();
	$suma_sedes = 0;
	foreach ($sedes as $sede){
		$cursos = DAOFactory::getCursosDAO()->getCursosInSede($sede->id);
		$suma_cursos = 0;
		//buscamos todos los cursos en una sede
		foreach ($cursos as $curso){
			$grupos = DAOFactory::getGruposDAO()->getGruposInCurso($curso->id);
			$suma_grupos = 0;
			//buscamos todos todos grupos en un curso
			foreach ($grupos as $grupo){
				$alumnos = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
				$suma_alumnos = 0;
				//buscamos todos los alumnos de un grupo (sumamos su tiempo)
				foreach ($alumnos as $alumno){
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->id]['nombre'] = $alumno->nombre.' '.$alumno->apellido;
					//desde el inicio de los tiempos hasta hoy
					$tiempo = DAOFactory::getLogsDAO()->getTiempoEntreFechas(0, time(), $alumno->id);
					$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->id]['tiempo'] = $tiempo;
					$suma_alumnos += $tiempo;
				}
				$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['tiempo'] = $suma_alumnos;
				$suma_grupos += $suma_alumnos;
			}
			$arbol_tiempo['detalle'][$sede->nombre]['detalle'][$curso->nombre]['tiempo'] = $suma_grupos; 
			$suma_cursos += $suma_grupos;
		}
		$arbol_tiempo['detalle'][$sede->nombre]['tiempo'] = $suma_cursos;
		$suma_sedes += $suma_cursos;
	}
	$arbol_tiempo['tiempo'] = $suma_sedes;
	
	//FIX
	$cadena = '[';
	foreach ($arbol_tiempo['detalle'] as $nombre => $nodo){
		$cadena .= '["'.$nombre.'",'.$nodo['tiempo'].'],';
	}
	
	$this->registry->template->arbol = substr($cadena, 0, -1).']';
	$this->registry->template->director = $director;
	$this->registry->template->sedes = $sedes;
	$this->registry->template->show('director/index');
}


public function data(){
	
	$arbol_tiempo = array();
	
	if(isset($_GET['grupo'])){
		/* árbol de tiempo para un curso */
		$id_director = $_GET['director'];
		$nombre_sede = $_GET['sede'];
		$nombre_curso = $_GET['curso'];
		$nombre_grupo =  $_GET['grupo'];
		
		$sede = DAOFACTORY::getSedesDAO()->getByDirectorAndNombre($id_director, $nombre_sede);
		$curso = DAOFactory::getCursosDAO()->getCursoBySedeAndNombre($sede->id, $nombre_curso);
		$grupo = DAOFactory::getGruposDAO()->getGrupoByCursoAndNombre($curso->id, $nombre_grupo);
		
		$arbol_tiempo['nombre'] = $grupo->nombre;
	
		$suma_grupos = 0;
		//buscamos todos todos grupos en un curso
		
		$alumnos = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
		$suma_alumnos = 0;
		//buscamos todos los alumnos de un grupo (sumamos su tiempo)
		foreach ($alumnos as $alumno){
			$arbol_tiempo['detalle'][$alumno->nombre]['nombre'] = $alumno->nombre.' '.$alumno->apellido;
			//desde el inicio de los tiempos hasta hoy
			$tiempo = DAOFactory::getLogsDAO()->getTiempoEntreFechas(0, time(), $alumno->id);
			$arbol_tiempo['detalle'][$alumno->nombre]['tiempo'] = $tiempo;
			$suma_alumnos += $tiempo;
		}
		$arbol_tiempo['tiempo'] = $suma_alumnos;
		
	}//termina el if
	
	elseif(isset($_GET['curso'])){
		/* árbol de tiempo para un curso */
		$id_director = $_GET['director'];
		$nombre_sede = $_GET['sede'];
		$nombre_curso = $_GET['curso'];
		
		$sede = DAOFACTORY::getSedesDAO()->getByDirectorAndNombre($id_director, $nombre_sede);
		$curso = DAOFactory::getCursosDAO()->getCursoBySedeAndNombre($sede->id, $nombre_curso);
		
		$arbol_tiempo['nombre'] = $curso->nombre;
		
		$grupos = DAOFactory::getGruposDAO()->getGruposInCurso($curso->id);
		$suma_grupos = 0;
		//buscamos todos todos grupos en un curso
		foreach ($grupos as $grupo){
			$alumnos = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
			$suma_alumnos = 0;
			//buscamos todos los alumnos de un grupo (sumamos su tiempo)
			foreach ($alumnos as $alumno){
				$arbol_tiempo['detalle'][$grupo->nombre]['detalle'][$alumno->id]['nombre'] = $alumno->nombre.' '.$alumno->apellido;
				//desde el inicio de los tiempos hasta hoy
				$tiempo = DAOFactory::getLogsDAO()->getTiempoEntreFechas(0, time(), $alumno->id);
				$arbol_tiempo['detalle'][$grupo->nombre]['detalle'][$alumno->id]['tiempo'] = $tiempo;
				$suma_alumnos += $tiempo;
			}
			$arbol_tiempo['detalle'][$grupo->nombre]['tiempo'] = $suma_alumnos;
			$suma_grupos += $suma_alumnos;
		}
	$arbol_tiempo['tiempo'] = $suma_grupos;
	}//termina el if
	
	elseif(isset($_GET['sede'])){
		/* árbol de tiempo para una sede */
		$id_director = $_GET['director'];
		$nombre_sede = $_GET['sede'];
		
		$sede = DAOFACTORY::getSedesDAO()->getByDirectorAndNombre($id_director, $nombre_sede);
		$arbol_tiempo['nombre'] = $sede->nombre;
		//comienza iteración
		$cursos = DAOFactory::getCursosDAO()->getCursosInSede($sede->id);
		$suma_cursos = 0;
		//buscamos todos los cursos en una sede
		foreach ($cursos as $curso){
			$grupos = DAOFactory::getGruposDAO()->getGruposInCurso($curso->id);
			$suma_grupos = 0;
			//buscamos todos todos grupos en un curso
			foreach ($grupos as $grupo){
				$alumnos = DAOFactory::getPersonasDAO()->getEstudiantesInGroup($grupo->id);
				$suma_alumnos = 0;
				//buscamos todos los alumnos de un grupo (sumamos su tiempo)
				foreach ($alumnos as $alumno){
					$arbol_tiempo['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->id]['nombre'] = $alumno->nombre.' '.$alumno->apellido;
					//desde el inicio de los tiempos hasta hoy
					$tiempo = DAOFactory::getLogsDAO()->getTiempoEntreFechas(0, time(), $alumno->id);
					$arbol_tiempo['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['detalle'][$alumno->id]['tiempo'] = $tiempo;
					$suma_alumnos += $tiempo;
				}
				$arbol_tiempo['detalle'][$curso->nombre]['detalle'][$grupo->nombre]['tiempo'] = $suma_alumnos;
				$suma_grupos += $suma_alumnos;
			}
			$arbol_tiempo['detalle'][$curso->nombre]['tiempo'] = $suma_grupos;
			$suma_cursos += $suma_grupos;
		}
		$arbol_tiempo['tiempo'] = $suma_cursos;	
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
