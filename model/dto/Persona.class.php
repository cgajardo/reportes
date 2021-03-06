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
		
		var $password;

		var $correo;

		var $identificadorMoodle;

		var $rolMoodle;
		
		var $idInstitucion;
		
		//esta funcion permite obtener el rol de un usuario en una plataforma dada
		public function getRol(){
                        $esRector = DAOFactory::getPersonasDAO()->checkRolDirector($this->id);
			if($esRector)
				return "rector";
			$esProfesor = DAOFactory::getPersonasDAO()->checkRolProfesor($this->id);
			if($esProfesor)
				return "profesor";			
                        $esAlumno = DAOFactory::getPersonasDAO()->checkRolAlumno($this->id);
			if($esAlumno)
				return "alumno";
		}
		
		public function getRolEnGrupo($id_grupo){
			//buscamos el rol del usuario
			$rol = $this->getRol();
			//segun el usuario revisamos si tiene efectivamente el rol en el grupo
			switch ($rol){
				case "alumno":
					$registro = DAOFactory::getGruposHasEstudiantesDAO()->load($this->id, $id_grupo);
					if($registro!=null)
						return $rol;
					else
						return null;
				case "profesor":
					$registro = DAOFactory::getGruposHasProfesoresDAO()->load($this->id, $id_grupo);
					if($registro!=null)
						return $rol;
					else
						return null;
				case "rector":
					return $rol;
					break;
			}
		}

		
	}
?>