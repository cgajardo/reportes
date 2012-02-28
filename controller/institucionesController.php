<?php

Class institucionesController Extends baseController {

public function index() {
	$instituciones = DAOFactory::getInstitucionesDAO()->queryAll();
	$this->registry->template->instituciones = $instituciones;
	$this->registry->template->show('instituciones/index');  
}

public function agregar(){
	$institucion = new Institucione();
	$this->editar($institucion);
}

public function guardar(){
	
	if(!isset($_POST['nombre']) || !isset($_POST['nombreCorto']) 
			|| !isset($_POST['prefijo']) || !isset($_POST['notaAprobado'])){
		
		$this->registry->template->mensaje = "Todos los campos son requeridos.";
		//probablemente con un mensaje de error
		$this->registry->template->ruta = "instituciones";
		$this->registry->template->show('enrutador');
	}
	
	if(isset($_POST['id'])){
		$institucion = DAOFactory::getInstitucionesDAO()->load($_POST['id']);
	}else{
		$institucion = new Institucione();
	}
	
	$institucion->nombre = $_POST['nombre'];
	$institucion->nombreCorto = $_POST['nombreCorto'];
	$institucion->prefijoEvaluacion = $_POST['prefijo'];
	$institucion->notaAprobado = $_POST['notaAprobado'];
        $institucion->notaSuficiente= $_POST['notaSuficiente'];
	$institucion->plataforma = $_POST['plataforma'];
	
	if(isset($_POST['id'])){
		DAOFactory::getInstitucionesDAO()->update($institucion);
		$this->registry->template->mensaje = "Instituci&oacute;n actualizada correctamente";
	}else{
		DAOFactory::getInstitucionesDAO()->insert($institucion);
		$this->registry->template->mensaje = "Instituci&oacute;n agregada correctamente";
	}
	
	
	$this->registry->template->ruta = "instituciones";
	$this->registry->template->show('enrutador');
}

public function editar($institucion = null){
	if($institucion == null){
		$id = $_GET['id'];
		$institucion = DAOFactory::getInstitucionesDAO()->load($id);
		$this->registry->template->update = true;
	}
	
	$this->registry->template->institucion = $institucion;
	$this->registry->template->plataformas = DAOFactory::getPlataformasDAO()->queryAll();
	//finally
	$this->registry->template->show('instituciones/editar');
}


public function view(){

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

public function eliminar(){
	$id = $_GET['id'];
	DAOFactory::getInstitucionesDAO()->delete($id);
	
	$this->registry->template->mensaje_exito = "Institucion eliminada correctamente";
	
	$this->registry->template->ruta = "instituciones";
	$this->registry->template->show('enrutador');

}

}
?>
