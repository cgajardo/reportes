<?php

Class indexController Extends baseController {

public function index() {
     $this->registry->template->show('index/bienvenido');
}

public function showtest(){
	session_start();
	session_destroy();
        $grupos = DAOFactory::getGruposDAO()->queryAll();
        //$directores = DAOFactory::getPersonasDAO()->getDirectores();
        print 'enrutador/index?params='.$this->encrypter->encode('platform=instituto&username=16648841');
        print '<br>enrutador/index?params='.$this->encrypter->encode('platform=instituto&username=18081351');
        print '<br>enrutador/index?params='.$this->encrypter->encode('platform=instituto&username=15806964');
        print '<br>enrutador/index?params='.$this->encrypter->encode('platform=instituto&username=anamaria');

        //$this->registry->template->profesores = $profesores;
        //$this->registry->template->alumnos = $alumnos;
        $this->registry->template->encrypter = $this->encrypter;
        
	/*** load the index template ***/
	$this->registry->template->show('index');
}

}

?>
