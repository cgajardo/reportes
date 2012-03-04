<?php
include 'views/contenidos/pagination.php';
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
    $contenidos = DAOFactory::getContenidosDAO()->queryAllWithPadre();
    
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
	$contenido->padre = $_POST['padre'];
	if(isset($_POST['id'])){
            $contenido->id=$_POST['id'];
            DAOFactory::getContenidosDAO()->update($contenido);
        }else{
            DAOFactory::getContenidosDAO()->insert($contenido);
        }
	
	$this->index();
}

public function editar($contenido = null){
	
        if($contenido==null){
            try{
                $id = $_GET['id'];
                $contenido = DAOFactory::getContenidosDAO()->load($id); 
            }catch(Exception $e){}
        }
        $this->registry->template->contenido = $contenido;
	$this->registry->template->contenidos = DAOFactory::getContenidosDAO()->queryAllWithPadre();
	//finally
	$this->registry->template->show('contenidos/editar');
	
}

public function asociar(){
	
	session_start();
		
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
                if(isset($_GET['patron'])){
                    $this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getFromWithPatron(($page-1)*20,20,$_GET['patron']);
                }else{
                    $this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getFrom(($page-1)*20,20);
                }
		$this->registry->template->total = DAOFactory::getPreguntasDAO()->count();
	}
	
	//buscar o recuperar todos los contenidos
	if(isset($_SESSION['contenidos'])){
		$this->registry->template->contenidos = $_SESSION['contenidos'];
	} else{ 
                $contenidos = DAOFactory::getContenidosDAO()->queryAll();
		$this->registry->template->contenidos = $contenidos;
		$_SESSION['contenidos']  = $contenidos;
	}
	
	$this->registry->template->page = $page;
	//finally
	$this->registry->template->show('contenidos/asociar');
}

public function asociar2(){
    
        $file = fopen('views/contenidos/c.csv', 'r');
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

public function buscar_ajax(){
    $patron = utf8_decode($_GET['patron']);
    $todas_las_preguntas = DAOFactory::getPreguntasDAO()->getPreguntaByPatron($patron);
    if(isset($_SESSION['contenidos'])){
        $this->registry->template->contenidos = $_SESSION['contenidos'];
    } else{ 
        $contenidos = DAOFactory::getContenidosDAO()->queryAll();
        $this->registry->template->contenidos = $contenidos;
        $_SESSION['contenidos']  = $contenidos;
    }
    
    $combo = 'name="contenido" onchange="loadXMLDoc(this.value, this.id)">';
    $combo.='<option value="-1">Seleccione un Contenido</option>';
    foreach ($_SESSION['contenidos'] as $contenido){
        $combo.='<option value="'.utf8_encode($contenido->id).'">'.utf8_encode($contenido->nombre).'</option>';
    } 
    $combo.='</select>';
    print '<table class="paginable" align="center">
        <tr>
            <th>Pregunta</th>
            <th>Contenido asociado</th>
            <th>Elegir otro contenido</th>
        </tr>';
    foreach($todas_las_preguntas as $pregunta){
            echo '<tr>';
            echo '<td>'.utf8_encode($pregunta->nombre).'</td>';
            if ($pregunta->contenido) {
                echo '<td id="'.utf8_encode($pregunta->id).'">'.utf8_encode($pregunta->contenido->nombre).'</td>';
            }else{
                echo '<td id="'.utf8_encode($pregunta->id).'"></td>';
            }
            echo '<td>'.'<select id="'.utf8_encode($pregunta->id).'" '.$combo.'</td>';
            echo '</tr>';
    }

    print '</table>';
    print '<table align="center"><tr><td>'.pagination("0", count($contenidos),$patron).'</td></tr></table>';
    
    $this->registry->template->show('debug');
}

}
?>
