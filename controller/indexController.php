<?php

Class indexController Extends baseController {

public function index() {
	session_start();
	session_destroy();
	//echo $this->encrypter->encode("platform=utfsm&username=cgajardo");
	/*** load the index template ***/
     $this->registry->template->show('index');
}

}

?>
