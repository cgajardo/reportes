<?php

Class contenidosController Extends baseController {
	
public function asociar_ajax(){
	$id_contenido = $_GET['id_contenido'];
	$id_pregunta = $_GET['id_pregunta'];
	$pregunta = DAOFactory::getPreguntasDAO()->load($id_pregunta);
	$pregunta->idContenido = $id_contenido; 
	DAOFactory::getPreguntasDAO()->update($pregunta);
	$contenido = DAOFactory::getContenidosDAO()->load($id_contenido);
	echo utf8_encode($contenido->nombre);
}

public function index() 
{
    $contenidos = DAOFactory::getContenidosDAO()->queryAll();
    
    $this->registry->template->contenidos = $contenidos;
    
    //finally
    $this->registry->template->show('contenidos/index');
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
	
	session_start();
	
	
	
	print_r($todas_las_preguntas);
	
	$this->registry->template->preguntas_sin_asociar = $preguntas_sin_asociar;
	
	//paginacion
	if(!isset($_GET['page'])){
		$page = 1;
	}else{
		$page = $_GET['page'];
	}
	
	//aplicar filtro
	if(isset($_GET['filter'])){
		$this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getSinAsociarFrom(($page-1)*20,20);
		$this->registry->template->total = DAOFactory::getPreguntasDAO()->countSinAsociar();
	} else{
		$this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getFrom(($page-1)*20,20);
		$this->registry->template->total = DAOFactory::getPreguntasDAO()->count();
	}
	
	//buscar o recuperar todos los contenidos
	if(isset($_SESSION['contenidos'])){
		$this->registry->template->contenidos = $_SESSION['contenidos'];
	} else{
		$this->registry->template->contenidos = DAOFactory::getContenidosDAO()->queryAll();
		$_SESSION['contenidos']  = $this->registry->template->contenidos;
	}
	
	$this->registry->template->page = $page;
	//finally
	$this->registry->template->show('contenidos/asociar');
}

public function asociar2(){
    
        $file = fopen('views/contenidos/contenidos.csv', 'r');
        fgets($file);
        while($x=fgets($file)){
            $cont = explode(';',$x);
            var_dump($cont);            
            if(($len=count($cont))>3){
                $preg = DAOFactory::getPreguntasDAO()->getPreguntaByCategoria($cont[0].'\;'.$cont[1]);
                print $cont[0].";".$cont[1];
                var_dump($preg);
            }else{
                $preg = DAOFactory::getPreguntasDAO()->getPreguntaByCategoria($cont[0]);
            }
            print " numero: ".intval($cont[$len-1])."<br/>";          
            foreach($preg as $p){
                $p->contenido=intval($cont[$len-1]);
                DAOFactory::getPreguntasDAO()->update($p);
            }
            
        }
    
        $this->registry->template->show('debug');
}

public function eliminar(){
	
	$id_contenido = $_GET['id'];
	DAOFactory::getContenidosDAO()->delete($id_contenido);
	
	//TODO enviar mensajes de 'eliminacion correcta'
	$this->index();
}

public function autocompletar(){
	$this->registry->template->show('contenidos/autocomplete');
}

}
?>
