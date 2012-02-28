<?php

Class sedesController Extends baseController {

public function index() 
{       
        $ins = DAOFactory::getInstitucionesDAO()->queryAll();
        foreach($ins as $institucion){
            $instituciones[$institucion->nombre]=  DAOFactory::getSedesDAO()->getSedesByInstitucion($institucion->id);
        }
        $this->registry->template->instituciones = $instituciones;
        
        $this->registry->template->show('sedes/index');
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
        $sede->idInstitucion = $_POST['institucion'];
	if(isset($_POST['id'])){
            $sede->id = $_POST['id'];
            DAOFactory::getSedesDAO()->update($sede);
        }else{
            DAOFactory::getSedesDAO()->insert($sede);
        }
	
	$this->registry->template->mensaje_exito = "Sede agregada correctamente";

	$this->index();
}

public function editar($sede = null){
	if($sede == null){
		$id = $_GET['id'];
		$sede = DAOFactory::getSedesDAO()->load($id);
	}        
	$this->registry->template->sede = $sede;
	$this->registry->template->instituciones = DAOFactory::getInstitucionesDAO()->queryAll();
	
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
        
        $this->registry->template->ruta = "sedes";
	$this->registry->template->show('enrutador');
}

}
?>
