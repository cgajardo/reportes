<?php

Class usuariosController Extends baseController {

public function index() {
	$usuarios = DAOFactory::getUsuariosDAO()->queryAll();
	$this->registry->template->usuarios = $usuarios;
	$this->registry->template->show('usuarios/index');  
}

public function agregar(){
	$persona = new Persona();
	$this->editar($persona);
}

public function guardar(){
	
	if(!isset($_POST['nombres']) || !isset($_POST['apellidos']) || !isset($_POST['email']) ){
		
		$this->registry->template->mensaje = "Todos los campos son requeridos.";
		//probablemente con un mensaje de error
		$this->registry->template->ruta = "usuarios";
		$this->registry->template->show('enrutador');
	}
	
	if(isset($_POST['id'])){
		$usuario = DAOFactory::getUsuariosDAO()->load($_POST['id']);
		$mensaje = "Tu cuenta en el Sistema de Reportes Galyleo ha sido actualizada, tu nueva clave es: ";
	}else{
		$usuario = new Usuario();
		$mensaje = "Tu cuenta en el Sistema de Reportes Galyleo ha sido creada, tu clave es: ";
	}
	
	$usuario->nombres = $_POST['nombres'];
	$usuario->apellidos = $_POST['apellidos'];
	$usuario->email = $_POST['email'];
	$usuario->password = $this->generatePassword();
	
	//terminanos de armar el mensaje 
	$mensaje = "Estimado ".$usuario->nombres."<br/> ".$mensaje."<b>".$usuario->password."</b>";
	
	
	if(isset($_POST['id'])){
		DAOFactory::getUsuariosDAO()->update($usuario);
		$this->registry->template->mensaje = "Usuario actualizada correctamente";
	}else{
		DAOFactory::getUsuariosDAO()->insert($usuario);
		$this->registry->template->mensaje = "Usuario agregada correctamente";
	}
	
	$this->mailer->send($usuario->email, "Tu cuenta en Reportes Galyleo", $mensaje);
	
	$this->registry->template->ruta = "usuarios";
	$this->registry->template->show('enrutador');
}

public function editar($usuario = null){
	
	if($usuario == null){
		$id = $_GET['id'];
		$usuario = DAOFactory::getUsuariosDAO()->load($id);
		$this->registry->template->update = true;
	}
	
	$this->registry->template->usuario = $usuario;
	$this->registry->template->sedes = DAOFactory::getSedesDAO()->queryAll();
	$this->registry->template->instituciones = DAOFactory::getInstitucionesDAO()->queryAll();
	
	//finally
	$this->registry->template->show('usuarios/editar');
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

private function generatePassword ($length = 8){
    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "#%&!?2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;
}

}
?>
