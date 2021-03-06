<?php
Class enrutadorController Extends baseController {
	
	public function index(){
		session_start();
		session_destroy();
		session_start();
		//desencriptamos los datos que nos envian desde moodle
		$PARAMS = $this->encrypter->decodeURL($_GET['params']);
		
		// redireccionamos al 404 si no viene los datos esperados
		if(!isset($PARAMS['platform']) || !isset($PARAMS['username'])){
			$this->registry->template->mesaje_personalizado = "Ha ocurrido con error que impide verificar tu cuenta. </br>
			Por favor informa este error a reportes@galyleo.net";
			//finally
			$this->registry->template->show('error404');
			return;
		}
		
		$nombre_plataforma = $PARAMS['platform'];
		$username = $PARAMS['username'];
		$cola = '';
		
		if(isset($PARAMS['course'])){
			$course = $PARAMS['course'];
			$curso = DAOFactory::getCursosDAO()->queryByIdentificadorMoodle($nombre_plataforma.'_'.$course);
			$cola = "?params=".$this->encrypter->encode('curso='.$curso->id);
		}
		
		$usuario = DAOFactory::getPersonasDAO()->getUserInPlatform($nombre_plataforma,$username);
		$_SESSION['usuario'] = $usuario;
		$_SESSION['plataforma'] = $nombre_plataforma;
		
		session_commit();
		
		$rol = $usuario->getRol();
		//aumentamos el contador del usuario
		//DAOFactory::getPersonasDAO()->updateVisitCounter($username);
		
		switch ($rol) {
			case "rector":
				$this->registry->template->ruta ="directores"; 
				$this->registry->template->show('enrutador');
				break;
                        case "profesor":
				$this->registry->template->ruta ="profesores"; 
				$this->registry->template->show('enrutador');
				break;
                            
                        case "alumno":
				$this->registry->template->ruta ="alumnos".$cola; 
				$this->registry->template->show('enrutador');
				break;
			
			
		}
		
		
		
	}
	
}
?>