<?php
Class reportesController Extends baseController {

public function index() {
	session_start();
	//print $this->encrypter->encode("platform=utfsm&user=574&course=6");
	//578, 586, 587, 599, 581, 574
	$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	//print_r($PARAMS);
	// 	if(isset($_SESSION['usuario'])){
	// 		$usuario = $_SESSION['usuario'];
	// 		$platform = $_SESSION['plataforma'];
	// 	}
	if(isset($PARAMS['platform'])){
		$user_id_in_moodle = $PARAMS['user'];
		$platform = $PARAMS['platform'];
		$usuario = DAOFactory::getPersonasDAO()->getUserInPlatform($platform,$user_id_in_moodle);
		//lo agregamos a la session
		$_SESSION['usuario'] = $usuario;
		$_SESSION['plataforma'] = $platform;
	}
	elseif(isset($PARAMS['plataforma'])){
		$user_id = $PARAMS['usuario'];
		$platform = $PARAMS['plataforma'];
		$usuario = DAOFactory::getPersonasDAO()->load($user_id);
		//lo agregamos a la session
		$_SESSION['usuario'] = $usuario;
		$_SESSION['plataforma'] = $platform;
	}
	
	$cursos_usuarios = DAOFactory::getCursosDAO()->getCursosByUsuario($usuario->id);
	$institucion = DAOFactory::getInstitucionesDAO()-> getInstitucionByNombrePlataforma($platform);
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
	/* caso en que el usuario ya selecciono el curso desde la plataforma galyleo */
	elseif (isset($PARAMS['curso'])){
		$id_curso = $PARAMS['curso'];
		
		$quizes = DAOFactory::getQuizesDAO()->queryEvaluacionesByIdCurso($id_curso);
		
		$this->registry->template->titulo = 'Tus evaluaciones';
		$this->registry->template->usuario = $usuario;
		$this->registry->template->cursos = $cursos_usuarios;
		$this->registry->template->origen = '&plataforma='.$platform.'&usuario='.$usuario->id;
		$this->registry->template->encrypter = $this->encrypter;
		$this->registry->template->quizes = $quizes;
		$this->registry->template->id_curso = $id_curso;
		$this->registry->template->retorno = $this->encrypter->encode('&plataforma='.$platform.'&usuario='.$usuario->id);
		//finally
		$this->registry->template->show('reportes/index_quizes');
		return;
	}
	
	/* caso en que el usuario ya selecciono el curso desde la plataforma moodle */
	elseif (isset($PARAMS['course'])){
		$curso_moodle = $PARAMS['course'];
		$curso = DAOFactory::getCursosDAO()->queryByIdentificadorMoodle($platform.'_'.$curso_moodle);	
		$quizes = DAOFactory::getQuizesDAO()->queryEvaluacionesByIdCurso($curso->id);
		
		$this->registry->template->titulo = 'Tus evaluaciones';
		$this->registry->template->usuario = $usuario;
		$this->registry->template->cursos = $cursos_usuarios;
		$this->registry->template->origen = '&plataforma='.$platform.'&usuario='.$usuario->id;
		$this->registry->template->encrypter = $this->encrypter;
		$this->registry->template->quizes = $quizes;
		$this->registry->template->id_curso = $curso->id;
		$this->registry->template->retorno = $this->encrypter->encode('&plataforma='.$platform.'&usuario='.$usuario->id);
		//finally
		$this->registry->template->show('reportes/index_quizes');
	
	$this->registry->template->titulo = 'Tus cursos';
	$this->registry->template->usuario = $usuario;
	$this->registry->template->cursos = $cursos_usuarios;
	$this->registry->template->origen = '&plataforma='.$platform.'&usuario='.$usuario->id;
	$this->registry->template->encrypter = $this->encrypter;
    //finally
    $this->registry->template->show('reportes/index_cursos');

	}
}

?>
