<?php

Class indexController Extends baseController {

public function index() {
     $this->registry->template->show('index/bienvenido');
}

public function showtest(){
	session_start();
	session_destroy();
        print $this->encrypter->decode('lnFtbVjp2gnQMUkAa_1qgT64fPt6LOGc-TUl-mqUeO7dzTl256IVTQ');
        
	/*** load the index template ***/
	$this->registry->template->show('index');
}

}

?>
