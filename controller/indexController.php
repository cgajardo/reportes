<?php

Class indexController Extends baseController {

public function index() {
     $this->registry->template->show('index/bienvenido');
}

public function showtest(){
	session_start();
	session_destroy();
        $grupos = DAOFactory::getGruposDAO()->queryAll();
        $alumnos = DAOFactory::getPersonasDAO()->queryByRolMoodle("student");
        $profesores = DAOFactory::getPersonasDAO()->queryByRolMoodle("teacher");
        //$directores = DAOFactory::getPersonasDAO()->getDirectores();
        print 'enrutador/?params='.$this->encrypter->encode('platform=instituto&username=15806964');

        //$this->registry->template->profesores = $profesores;
        //$this->registry->template->alumnos = $alumnos;
        $this->registry->template->encrypter = $this->encrypter;
        
	/*** load the index template ***/
	$this->registry->template->show('index');
}

}

?>
