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

public function cursos(){
    
    $cursos = DAOFactory::getCursosDAO()->queryAll();
    
    $this->registry->template->cursos = $cursos;
    $this->registry->template->show('sedes/cursos');

}

public function grupos(){
    $curso_id = $_GET['curso'];
    $sedes = DAOFactory::getSedesDAO()->queryAll();
    $curso = DAOFactory::getCursosDAO()->load($curso_id);
    $grupos = DAOFactory::getGruposDAO()->getGruposInCurso($curso_id);
    $instituciones = DAOFactory::getInstitucionesDAO()->queryAll();    
    
    $combo='<option>Seleccione una Sede</option>';
    foreach($instituciones as $institucion){
        $sedes = DAOFactory::getSedesDAO()->getSedesByInstitucion($institucion->id);
        $combo.='<optgroup label="'.$institucion->nombreCorto.'">';
        foreach($sedes as $sede){
            $combo.='<option value="'.$sede->id.'">'.$sede->nombre.'</option>';
            $sedesById[$sede->id] = $sede;
        }
        $combo.='</optgroup>';
    }
    $combo.='</select>';
    
    foreach ($instituciones as $institucion){
        $institucionesById[$institucion->id]=$institucion;
    }
    
    $this->registry->template->curso = $curso;
    $this->registry->template->grupos = $grupos;
    $this->registry->template->combo = $combo;
    $this->registry->template->sedes = $sedesById;
    
    
    $this->registry->template->show('sedes/grupos');
    
}

public function asociarCurso(){
    $idSede = $_GET['sede'];
    $idCurso = $_GET['curso'];
    $grupos = DAOFactory::getGruposDAO()->getGruposInCurso($idCurso);
    foreach($grupos as $grupo){
        $grupo->idSede=$idSede;
        DAOFactory::getGruposDAO()->update($grupo);
    }
    
}

public function asociarGrupo(){
    $grupo = DAOFactory::getGruposDAO()->load($_GET['grupo']);
    $sede = $_GET['sede'];
    $grupo->idSede = $sede;
    DAOFactory::getGruposDAO()->update($grupo);
    
    $sede =  DAOFactory::getSedesDAO()->load($sede);
    print $sede->nombre;
    
    $this->registry->template->show('debug');
    }

}

?>