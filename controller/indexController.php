<?php

Class indexController Extends baseController {

public function index() {
	session_start();
	
	session_destroy();
	/*** load the index template ***/
     $this->registry->template->show('index');
}

}

?>
