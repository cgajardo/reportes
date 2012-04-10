<?php

Class indexController Extends baseController {

public function index() {
     $this->registry->template->show('index/bienvenido');
}

public function showtest(){
	session_start();
	session_destroy();
        echo $this->encrypter->encode("platform=instituto&username=16739676");
	/*** load the index template ***/
	$this->registry->template->show('index');
}

}

?>
