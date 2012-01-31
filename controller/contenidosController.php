<?php

Class contenidosController Extends baseController {
	
public function asociar_ajax(){
	$id_contenido = $_GET['id_contenido'];
	$id_pregunta = $_GET['id_pregunta'];
	$pregunta = DAOFactory::getPreguntasDAO()->load($id_pregunta);
	$pregunta->idContenido = $id_contenido; 
	DAOFactory::getPreguntasDAO()->update($pregunta);
	$this->asociar();
}

public function index() 
{
    $contenidos = DAOFactory::getContenidosDAO()->queryAll();
    
    $this->registry->template->contenidos = $contenidos;
    
    //finally
    $this->registry->template->show('contenidos_index');
}

public function agregar(){
	$contenido = new Contenido();
	$this->editar($contenido);
}

public function guardar(){
	$contenido = new Contenido();
	$contenido->nombre = $_POST['nombre'];
	$contenido->linkRepaso = $_POST['linkRepaso'];
	$contenido->fraseLogrado = $_POST['fraseLogrado'];
	$contenido->fraseNoLogrado = $_POST['fraseNoLogrado'];
	DAOFactory::getContenidosDAO()->insert($contenido);
	
	$this->index();
}

public function editar($contenido = null){
	if($contenido == null){
		$id = $_GET['id'];
		$contenido = DAOFactory::getContenidosDAO()->load($id); 
	}
	
	$this->registry->template->contenido = $contenido;
	//finally
	$this->registry->template->show('contenidos/editar');

}

public function asociar(){
	
	$preguntas_sin_asociar = DAOFactory::getPreguntasDAO()->getAllSinContenido();
	$this->registry->template->preguntas_sin_asociar = $preguntas_sin_asociar;
	$this->registry->template->total_preguntas_sin_asociar = count($preguntas_sin_asociar);
	$this->registry->template->contenidos = DAOFactory::getContenidosDAO()->queryAll();
	
	//finally
	$this->registry->template->show('contenidos/contenidos_asociar');
}

public function eliminar(){
	$id_contenido = $_GET['id'];
	DAOFactory::getContenidosDAO()->delete($id_contenido);
	
	//TODO enviar mensajes de 'eliminacion correcta'
	$this->index();
	
}

}
?>
