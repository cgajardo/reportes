<?php
	/**
	 * Object represents table 'usuarios'
	 *
     	 * @author: http://phpdao.com
     	 * @date: 2012-02-21 18:03	 
	 */
	class Usuario{
		
		var $id;

		var $nombres;

		var $apellidos;

		var $email;

		var $password;

		public function getRol(){
			$esRector = DAOFactory::getUsuariosDAO()->checkRolRector($this->id);
			if($esRector)
				return "rector";
		}
		
		public function getRolEnGrupo($id_grupo){
			//buscamos el rol del usuario
			$rol = $this->getRol();
			//segun el usuario revisamos si tiene efectivamente el rol en el grupo
			switch ($rol){
				case "rector":
					return $rol;
					break;
			}
		}
                
	}
?>