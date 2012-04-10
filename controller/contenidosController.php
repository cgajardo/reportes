<?php
include 'views/contenidos/pagination.php';
Class contenidosController Extends baseController {
	
public function asociar_ajax(){
	$id_contenido = $_GET['id_contenido'];
	$id_categoria = $_GET['id_categoria'];
	$categoria = DAOFactory::getCategoriasDAO()->load($id_categoria);
	if($id_contenido!=-1){
            $categoria->idContenido = $id_contenido; 
        }else{
            $categoria->idContenido = NULL;
        }
	DAOFactory::getCategoriasDAO()->update($categoria);
	$contenido = DAOFactory::getContenidosDAO()->load($id_contenido);
	echo @utf8_encode($contenido->nombre);
}

public function index() 
{
    //print $this->encrypter->encode("platform=utfsm&username=17939412");
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

	if(isset($_POST['id']) && $_POST['id']!=''){
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
                    $this->registry->template->total = DAOFactory::getPreguntasDAO()->countWithPatron($_GET['patron']);
                }else{
                    $this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getFrom(($page-1)*20,20);
                    $this->registry->template->total = DAOFactory::getPreguntasDAO()->count();
                }
		
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
        $cursos = DAOFactory::getCursosDAO()->queryAll();
        foreach($cursos as $curso){
            $quizesByCurso[]= array($curso, DAOFactory::getQuizesDAO()->queryEvaluacionesByIdCurso($curso->id));
        }
        
        $this->registry->template->quizesByCurso = $quizesByCurso;
        
        $this->registry->template->show('contenidos/asociar2');
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
    
    if(isset($_GET['filter'])){
            $this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getSinAsociarFrom(($page-1)*20,20);
            $this->registry->template->total = DAOFactory::getPreguntasDAO()->countSinAsociar();
    } else{
            if(isset($_GET['patron'])){
                $this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getFromWithPatron(($page-1)*20,20,$_GET['patron']);
                $this->registry->template->total = DAOFactory::getPreguntasDAO()->countWithPatron($_GET['patron']);
            }else{
                $this->registry->template->todas_las_preguntas = DAOFactory::getPreguntasDAO()->getFrom(($page-1)*20,20);
                $this->registry->template->total = DAOFactory::getPreguntasDAO()->count();
            }

    }
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
    echo '<table class="paginable" align="center">
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
    
    echo '</table>';
    echo '<table align="center"><tr><td>'.pagination("0", count($contenidos),$patron).'</td></tr></table>';

    
    $this->registry->template->show('debug');
}

public function preguntas_quiz(){
    
    $id_quiz = $_GET['quiz'];
    
    $categorias = DAOFactory::getCategoriasDAO()->getCategoriasByQuizWithContenido($id_quiz);
    $contenidos = DAOFactory::getContenidosDAO()->getRealContenidos();
    $combo = 'name="contenido" onchange="loadPadres(this.value, this.id)">';
    $combo.='<option value="-1">Seleccione un Tema</option>';

    foreach ($contenidos as $contenido){
        $combo.='<option value="'.$contenido->id.'">'.$contenido->nombre.'</option>';
    } 
    $combo.='</select>';
    echo '<table class="paginable" align="center">
        <tr>
            <th>Pregunta</th>
            <th>Contenido asociado</th>
            <th colspan="3" >Elegir otro contenido</th>
        </tr>';
    foreach($categorias as $categoria){
            echo '<tr>';
            echo '<td>'.utf8_encode($categoria->nombre).'</td>';
            if ($categoria->idContenido) {
                echo '<td id="'.utf8_encode($categoria->id).'">'.utf8_encode($categoria->contenido->nombre).'</td>';
            }else{
                echo '<td id="'.utf8_encode($categoria->id).'"></td>';
            }
            echo '<td>'.'<select id="'.utf8_encode($categoria->id).'" '.$combo.'</td>';
            echo '<td id="padres'.$categoria->id.'"></td>';
            echo '<td id="hijos'.$categoria->id.'"></td>';
            echo '</tr>';
    }

    echo '</table>';
    $this->registry->template->show('debug');
}

public function contenidos_padres(){
	$id_contenido = $_GET['contenido'];
	$id_pregunta = $_GET['pregunta'];
	$contenidos = DAOFactory::getContenidosDAO()->getHijos($id_contenido);
	$combo = 'name="contenido" onchange="loadHijos(this.value, '.$id_pregunta.')">';
    $combo.='<option value="-1">Seleccione una Unidad</option>';
    foreach ($contenidos as $contenido){
        $combo.='<option value="'.$contenido->id.'">'.$contenido->nombre.'</option>';
    } 
    $combo.='</select>';
    
   	echo '<select id="'.$id_pregunta.'" '.utf8_encode($combo);

    $this->registry->template->show('debug');
	
}

public function contenidos_hijos(){
	$id_contenido = $_GET['contenido'];
	$id_pregunta = $_GET['pregunta'];
	$contenidos = DAOFactory::getContenidosDAO()->getHijos($id_contenido);
	$combo = 'name="contenido" onchange="asociar(this.value, '.$id_pregunta.')">';
	$combo.='<option value="-1">Seleccione un Contenido</option>';
	foreach ($contenidos as $contenido){
		$combo.='<option value="'.$contenido->id.'">'.$contenido->nombre.'</option>';
	}
	$combo.='</select>';

	echo '<select id="'.$id_pregunta.'" '.utf8_encode($combo);

	$this->registry->template->show('debug');

}

public function calendarios(){
        
        if(@$_POST['contenido']){
            //var_dump($_POST);
            $cursosHasContenidos = new CursosHasContenidos();
            $cursosHasContenidos->idCurso = $_POST['curso'];
            $cursosHasContenidos->idContenido = $_POST['contenido'];
            $cursosHasContenidos->frase = $_POST['frase'];
            $cursosHasContenidos->link = $_POST['link'];
            if($_POST['anoInicio']!=-1 && $_POST['mesInicio']!=-1 && $_POST['diaInicio']!=-1
                    && $_POST['horaInicio']!=-1 && $_POST['minInicio']!=-1){
                $cursosHasContenidos->fechaInicio = $_POST['anoInicio'].'-'.$_POST['mesInicio'].'-'.
                        $_POST['diaInicio'].' '.$_POST['horaInicio'].':'.$_POST['minInicio'];
            }else{
                if(@$_POST['inicioViejo']){
                    $cursosHasContenidos->fechaInicio = $_POST['inicioViejo'];
                }else{
                    $cursosHasContenidos->fechaInicio = 0;
                }
            }
            if($_POST['anoCierre']!=-1 && $_POST['mesCierre']!=-1 && $_POST['diaCierre']!=-1
                    && $_POST['horaCierre']!=-1 && $_POST['minCierre']!=-1){
                $cursosHasContenidos->fechaCierre = $_POST['anoCierre'].'-'.$_POST['mesCierre'].'-'.
                        $_POST['diaCierre'].' '.$_POST['horaCierre'].':'.$_POST['minCierre'];
            }else{
                if(@$_POST['cierreViejo']){
                    $cursosHasContenidos->fechaInicio = $_POST['cierreViejo'];
                }else{
                    $cursosHasContenidos->fechaInicio = 0;
                }
            }
            if(@$_POST['inicioViejo']){
                DAOFactory::getCursosHasContenidos()->update($cursosHasContenidos, $_POST['inicioViejo'], $_POST['cierreViejo']);                
            }else{
                DAOFactory::getCursosHasContenidos()->insert($cursosHasContenidos);
            }            
            $this->registry->template->idCurso= $_POST['curso'];
        }
        $sedes = DAOFactory::getSedesDAO()->queryAll();
        foreach ($sedes as $sede){
            $cursosBySede[$sede->nombre]=  DAOFactory::getCursosDAO()->getCursosInSede($sede->id);
        }
        
        $this->registry->template->cursosBySede = $cursosBySede;
        
        $this->registry->template->show('contenidos/calendarios');
}

public function calendario_curso(){
        
        $id_curso = $_GET['curso'];
        $actividades = DAOFactory::getCursosHasContenidos()->getByCursoWithContenidos($id_curso);
        echo '<table border="1" align="center"><tr><th></th><th>Eje</th><th>Tema</th><th>Fecha Inicio</th><th>Fecha Cierre</th><th>link</th></tr>';
            foreach($actividades as $actividad){
                    echo '<tr><td><button onclick="editar(\''.$actividad->fechaInicio.'\',\''.$actividad->fechaCierre.'\')">Editar</button>';
                    echo '<button onclick="eliminar(\''.$actividad->fechaInicio.'\',\''.$actividad->fechaCierre.'\')">Eliminar</button></td>';
                    echo '<td>'.utf8_encode($actividad->idContenido).'</td>';
                    echo '<td>'.utf8_encode($actividad->frase).'</td>';
                    echo '<td>'.utf8_encode($actividad->fechaInicio)."</td>";
                    echo '<td>'.utf8_encode($actividad->fechaCierre)."</td>";
                    echo '<td>'.utf8_encode($actividad->link).'</td></tr>';
                }
                
        echo '</table>';
        echo '<button onclick="crear()">Nuevo</button>';
        $this->registry->template->show('debug');
}
    public function editar_actividad(){

            $fechaInicioVieja= $_GET['fechaInicio'];
            $fechaCierreVieja= $_GET['fechaCierre'];
            $id_curso = $_GET['curso'];
            $actividad = DAOFactory::getCursosHasContenidos()->load($id_curso, $fechaInicioVieja, $fechaCierreVieja);
            $contenidos = DAOFactory::getContenidosDAO()->getRealContenidos();
            $combo_contenidos='<select name="contenido"><option value="-1">Elija Contenido</option>';
            foreach($contenidos as $contenido){
                $combo_contenidos.='<option value="'.$contenido->id.'"';
                if($contenido->id==$actividad->idContenido){
                    $combo_contenidos.=' selected';
                }
                $combo_contenidos.='>'.$contenido->nombre.'</option>';
            }
            $combo_contenidos.='</select>';
            $año = date("Y");
            $años='<option value="-1">Elija A&ntilde;o</option>';
            for($i=-1;$i<3;$i++){
                $años .= '<option value="'.($año+$i).'">'.($año+$i).'</option>';
            }
            $meses='<option value="-1">Elija Mes</option><option value="01">Enero</option><option value="02">Febrero</option><option value="03">Marzo</option>
                <option value="04">Abril</option><option value="05">Mayo</option><option value="06">Junio</option><option value="07">Julio</option>
                <option value="08">Agosto</option><option value="09">Septiembre</option><option value="10">Octubre</option><option value="11">Noviembre</option>
                <option value="12">Diciembre</option>';
            $dias='<option value="-1">Elija Día</option>';
            for($i=1;$i<10;$i++){
                $dias.='<option value="0'.$i.'">0'.$i.'</option>';
            }
            for($i=10;$i<32;$i++){
                $dias.='<option value"'.$i.'">'.$i.'</option>';
            }
            $horas='<option value="-1">Elija Hora</option>';
            for($i=0;$i<10;$i++){
                $horas.='<option value="0'.$i.'">0'.$i.'</option>';
            }
            for($i=10;$i<24;$i++){
                $horas.='<option value"'.$i.'">'.$i.'</option>';
            }
            $minutos='<option value="-1">Elija Minuto</option>';
            for($i=0;$i<10;$i++){
                $minutos.='<option value="0'.$i.'">0'.$i.'</option>';
            }
            for($i=10;$i<60;$i++){
                $minutos.='<option value"'.$i.'">'.$i.'</option>';
            }
            print '<h2 align="center">Edite Actividad</h2>';
            print '<form method="POST" action=""><table align="center">
                    <tr><td>Contenido:</td><td>'.utf8_encode($combo_contenidos).'</td></tr>
                    <tr><td>Frase:</td><td><textarea required name="frase" cols="50" rows="5" maxlenght="500">'.utf8_encode($actividad->frase).'</textarea></td></tr>
                    <tr><td>Fecha Inicio:</td><td><select name="anoInicio">'.$años.'</select>-<select name="mesInicio">'.$meses.'</select>-<select name="diaInicio">'.$dias.'</select>
                        <select name="horaInicio">'.$horas.'</select>:<select name="minInicio">'.$minutos.'</select><br>Actual: '.$fechaInicioVieja.'</td></tr>
                    <tr><td>Fecha Cierre:</td><td><select name="anoCierre">'.$años.'</select>-<select name="mesCierre">'.$meses.'</select>-<select name="diaCierre">'.$dias.'</select>
                        <select name="horaCierre">'.$horas.'</select>:<select name="minCierre">'.$minutos.'</select><br>Actual: '.$fechaCierreVieja.'</td></tr>
                    <tr><td>Link:</td><td><input name="link" required value="'.utf8_encode($actividad->link).'" size="50"></td></tr>
                    <tr><td><input type="button" onclick="ocultar()" value="Cerrar"/></td><td><button type="submit">Guardar</button></td></tr>
                </table>';
            print '<input name="inicioViejo" value="'.$actividad->fechaInicio.'" hidden/>';
            print '<input name="cierreViejo" value="'.$actividad->fechaCierre.'" hidden/>';
            print '<input name="curso" value="'.$actividad->idCurso.'" hidden/>';
            print '</form>';

        $this->registry->template->show('debug');

    }
    
    function crear_actividad(){

            $id_curso = $_GET['curso'];
            $contenidos = DAOFactory::getContenidosDAO()->getRealContenidos();
            $combo_contenidos='<select name="contenido"><option value="-1">Elija Contenido</option>';
            foreach($contenidos as $contenido){
                $combo_contenidos.='<option value="'.$contenido->id.'">'.$contenido->nombre.'</option>';
            }
            $combo_contenidos.='</select>';
            $año = date("Y");
            $años='<option value="-1">Elija A&ntilde;o</option>';
            for($i=-1;$i<3;$i++){
                $años .= '<option value="'.($año+$i).'">'.($año+$i).'</option>';
            }
            $meses='<option value="-1">Elija Mes</option><option value="01">Enero</option><option value="02">Febrero</option><option value="03">Marzo</option>
                <option value="04">Abril</option><option value="05">Mayo</option><option value="06">Junio</option><option value="07">Julio</option>
                <option value="08">Agosto</option><option value="09">Septiembre</option><option value="10">Octubre</option><option value="11">Noviembre</option>
                <option value="12">Diciembre</option>';
            $dias='<option>Elija Día</option>';
            for($i=1;$i<10;$i++){
                $dias.='<option value="0'.$i.'">0'.$i.'</option>';
            }
            for($i=10;$i<32;$i++){
                $dias.='<option value"'.$i.'">'.$i.'</option>';
            }
            $horas='<option>Elija Hora</option>';
            for($i=0;$i<10;$i++){
                $horas.='<option value="0'.$i.'">0'.$i.'</option>';
            }
            for($i=10;$i<24;$i++){
                $horas.='<option value"'.$i.'">'.$i.'</option>';
            }
            $minutos='<option value="-1">Elija Minuto</option>';
            for($i=0;$i<10;$i++){
                $minutos.='<option value="0'.$i.'">0'.$i.'</option>';
            }
            for($i=10;$i<60;$i++){
                $minutos.='<option value"'.$i.'">'.$i.'</option>';
            }
            print '<h2 align="center">Edite Actividad</h2>';
            print '<form method="POST" action=""><table align="center">
                    <tr><td>Contenido:</td><td>'.utf8_encode($combo_contenidos).'</td></tr>
                    <tr><td>Frase:</td><td><textarea required name="frase" cols="50" rows="5" maxlenght="500"></textarea></td></tr>
                    <tr><td>Fecha Inicio:</td><td><select required name="anoInicio">'.$años.'</select>-<select required name="mesInicio">'.$meses.'</select>-<select required name="diaInicio">'.$dias.'</select>
                        <select required name="horaInicio">'.$horas.'</select>:<select required name="minInicio">'.$minutos.'</select></td></tr>
                    <tr><td>Fecha Cierre:</td><td><select required name="anoCierre">'.$años.'</select>-<select required name="mesCierre">'.$meses.'</select>-<select required name="diaCierre">'.$dias.'</select>
                        <select required name="horaCierre">'.$horas.'</select>:<select required name="minCierre">'.$minutos.'</select></td></tr>
                    <tr><td>Link:</td><td><input name="link" required size="50"></td></tr>
                    <tr><td><input type="button" onclick="ocultar()" value="Cerrar"/></td><td><button type="submit">Guardar</button></td></tr>
                </table>';
            print '<input name="curso" value="'.$id_curso.'" hidden/>';
            print '</form>';

        $this->registry->template->show('debug');


    }
    
    public function eliminar_actividad(){
        $idCurso = $_GET['curso'];
        $fechaInicio = $_GET['fechaInicio'];
        $fechaCierre = $_GET['fechaCierre'];
        
        DAOFactory::getCursosHasContenidos()->delete($idCurso, $fechaInicio, $fechaCierre);
        
        print 'Actividad Eliminada';
        $this->registry->template->show('debug');
        
    }

}
?>
