<?php
	/**
	 * Object represents table 'personas'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2012-01-18 16:29	 
	 */
	class Persona{
		
		var $id;
		var $nombre;
		var $apellido;
		var $usuario;
		var $correo;
		var $rut;
		var $identificadorMoodle;
		var $rolMoodle;
		
		//esta funcion permite obtener el rol de un usuario en una plataforma dada
		public function getRol(){
			$esAlumno = DAOFactory::getPersonasDAO()->checkRolAlumno($this->id);
			if($esAlumno)
				return "alumno";
			$esProfesor = DAOFactory::getPersonasDAO()->checkRolProfesor($this->id);
			if($esProfesor)
				return "profesor";
			$esRector = DAOFactory::getPersonasDAO()->checkRolRector($this->id);
			if($esRector)
				return "rector";
		}
		
	}
?>