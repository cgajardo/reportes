<?php

Class institucionesController Extends baseController {

public function index() {
	$instituciones = DAOFactory::getInstitucionesDAO()->queryAll();
	$this->registry->template->instituciones = DAOFactory::getInstitucionesDAO()->queryAll();
	$this->registry->template->show('instituciones/index');  
}

public function agregar(){
	$sede = new Sede();
	$this->editar($sede);
}

public function guardar(){
	if(!isset($_POST['nombre'])){
		return $this->index();
	}
	$sede = new Sede();
	$sede->nombre = $_POST['nombre'];
	$sede->pais = $_POST['pais'];
	$sede->region = $_POST['region'];
	$sede->ciudad = $_POST['ciudad'];
	DAOFactory::getSedesDAO()->insert($sede);
	
	$this->registry->template->mensaje_exito = "Sede agregada correctamente";

	$this->index();
}

public function editar($sede = null){
	if($sede == null){
		$id = $_GET['id'];
		$sede = DAOFactory::getSedesDAO()->load($id);
	}
	$this->registry->template->sede = $sede;
	
	//finally
	$this->registry->template->show('sedes/editar');
}


public function view(){

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

public function eliminar(){
	$id = $_GET['id'];
	DAOFactory::getSedesDAO()->delete($id);

	//TODO enviar mensajes de 'eliminacion correcta'
	$this->registry->template->mensaje_exito = "Sede eliminada correctamente";
	$this->index();

}

}
?>
