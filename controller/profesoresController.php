<?php

Class profesoresController Extends baseController {


public function view(){

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

public function reporte(){
	$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	session_start();
        $usuario = $_SESSION['usuario'];
        $platform = $_SESSION['plataforma'];

	$grupo_id=$PARAMS['grupo'];
	$quiz_id = $PARAMS['quiz'];
	$rol = $usuario->getRolEnGrupo($grupo_id);
	if($rol != "profesor" && $rol != "rector"){
		$this->registry->template->mesaje_personalizado = "Tu rol no corresponde al de profesor.</br>".
				"Por lo tanto no puedes revisar el contenido de esta p&aacute;gina. ";
		//finally
		$this->registry->template->show('error404');
		return;	
	}
	//recuperamos los objetos que nos interesan
	$grupo = DAOFactory::getGruposDAO()->load($grupo_id);
	//$usuario = DAOFactory::getPersonasDAO()->load($user_id);
	$quiz = DAOFactory::getQuizesDAO()->load($quiz_id);

	
	//recuperamos los objetos que nos interesan
	if($rol =="profesor"){
            $institucion = DAOFactory::getInstitucionesDAO()-> getInstitucionByProfesor($usuario->id);
        }else{
            $institucion = DAOFactory::getInstitucionesDAO()-> getInstitucionByDirectorId($usuario->id);
        }
	$curso = DAOFactory::getCursosDAO()->getCursoByGrupoId($grupo->id);
	$estudiantes_en_grupo = DAOFactory::getPersonasDAO()->getEstudiantesInGrupoOrderByColumn($grupo->id,"apellido, nombre");
        $notas_grupo = DAOFactory::getIntentosDAO()->getNotasNombreGrupo($quiz->id,$grupo->id);
        $contenidos_quiz = DAOFactory::getContenidosDAO()->getContenidosByQuiz($quiz->id);
        $detalle_notas = DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupoDetalle($quiz->id,$grupo->id);
        
	//$nota_maxima= DAOFactory::getNotasDAO()->getMaxNotaInQuiz($quiz->id);
	//enviamos los siguientes valores a la vista
	$this->registry->template->titulo = 'Reporte Profesor';
	$this->registry->template->curso = $curso;
	$this->registry->template->grupo = $grupo;
	$this->registry->template->platform = $platform;
        $_SESSION['notas_grupo'] = $notas_grupo;
	$this->registry->template->quiz=$quiz;
	$this->registry->template->estudiantes =$estudiantes_en_grupo;
	$this->registry->template->total_estudiantes_grupo = count($estudiantes_en_grupo);
	$this->registry->template->nombre_actividad = $quiz->nombre;
	$this->registry->template->fecha_cierre = $quiz->fechaCierre;
	$this->registry->template->nombre_curso = $curso->nombre;
	$this->registry->template->nombre_grupo = $grupo->nombre;
	$this->registry->template->institucion = $institucion;
	$this->registry->template->nota_maxima = $quiz->notaMaxima;
	$this->registry->template->nota_minima = $quiz->notaMinima;
	$this->registry->template->porcentaje_aprobado = $institucion->notaAprobado;
	$this->registry->template->porcentaje_suficiente = $institucion->notaSuficiente;
                
	// esto es lo necesario para la matriz de desempeño, TODO: deber�a tener su vista propia?
	$quizes_en_grupo = DAOFactory::getQuizesDAO()->queryCerradosByIdGrupo($grupo->id);
	$matriz_desempeno = array();
	foreach ($quizes_en_grupo as $quiz_en_grupo){
		$logro_contenido=DAOFactory::getIntentosDAO()->getLogroPorContenidoGrupo($quiz_en_grupo->id,$grupo->id);
                if(empty($logro_contenido)){
                    $i=0;
                    foreach (DAOFactory::getContenidosDAO()->getContenidosByQuiz($quiz_en_grupo->id) as $contenido){
			$matriz_desempeño[$quiz_en_grupo->nombre][$i]['logro'] = -1;
                        $matriz_desempeño[$quiz_en_grupo->nombre][$i]['numero_preguntas'] = 0;
                        $matriz_desempeño[$quiz_en_grupo->nombre][$i]['contenido'] = $contenido;
                        $i++;
                    }
		}else{
			$matriz_desempeño[$quiz_en_grupo->nombre] = $logro_contenido;
		}
        }
        foreach($detalle_notas AS $nota){
            $matriz_contenidos[$contenidos_quiz[$nota['contenido']]->nombre][]=$nota;
        }
        $promedio=0;
        $preguntas=0;
        foreach($matriz_desempeno[$quiz->nombre] AS $contenido){
            $promedio+=$contenido['logro']*$contenido['numero_preguntas'];
            $preguntas+=$contenido['numero_preguntas'];
        }
        $promedio/=$preguntas;
        $this->registry->template->promedio_grupo=$promedio;
	$tiempo = DAOFactory::getLogsDAO()->getTiempoTarea($quiz->fechaCierre, $grupo->id);
	//enviamos estos elementos a la vista
	$_SESSION['matriz_desempeño'] = $matriz_desempeno;
	$_SESSION['matriz_contenidos'] = $matriz_contenidos;
	$_SESSION['tiempos'] = $tiempo;
	
	session_commit();
	//tiempo dedicado frente a cada quiz
	//finally
	$this->registry->template->show('profesor/reporte');
}

public function index(){
	session_start();
	
	//578, 586, 587, 599, 581, 574
	@$PARAMS = $this->encrypter->decodeURL($_GET['params']);
	
	//var_dump($PARAMS);
	// el usuario y la plataforma siempre vendrán en session
	$usuario = $_SESSION['usuario'];
	$platform = $_SESSION['plataforma'];
	
	$cursos_usuarios = DAOFactory::getCursosDAO()->getCursosByProfesor($usuario->id);
	$institucion = DAOFactory::getInstitucionesDAO()->load($usuario->idInstitucion);
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
	elseif (isset($PARAMS['grupo'])){
		$id_grupo = $PARAMS['grupo'];
		$id_curso = $PARAMS['curso'];
		$quizes = DAOFactory::getQuizesDAO()->queryCerradosByIdGrupo($id_grupo);
                
		$this->registry->template->titulo = 'Tus evaluaciones';
		$this->registry->template->usuario = $usuario;
		$this->registry->template->cursos = $cursos_usuarios;
		$this->registry->template->origen = '&plataforma='.$platform.'&usuario='.$usuario->id;
		$this->registry->template->encrypter = $this->encrypter;
		$this->registry->template->quizes = $quizes;
		$this->registry->template->id_curso = $id_curso;
		$this->registry->template->id_grupo = $id_grupo;
		//finally
		$this->registry->template->show('profesor/index_quizes');
		return;
	}
        
	
	$this->registry->template->titulo = 'Tus cursos';
	$this->registry->template->usuario = $usuario;
	$this->registry->template->cursos = $cursos_usuarios;
	$this->registry->template->encrypter = $this->encrypter;
    //finally
    
    
    $this->registry->template->show('profesor/index_cursos');
}

public function data(){
    
//    session_start();
//    $usuario = explode(', ',$_GET['alumno']);
//    foreach($_SESSION['notas_grupo'] as $id=>$nota){
//        if($nota->nombre==$usuario[1] && $nota->apellido==$usuario[0]){
//            $id_usuario = $id;
//            break;
//        }
//    }
    print $this->encrypter->encode('curso='.$_GET['curso'].'&quiz='.$_GET['quiz'].'&alumno='.$_GET['alumno']);
    $this->registry->template->show('debug');
}
}
?>
