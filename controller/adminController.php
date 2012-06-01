<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminController
 *
 * @author JorgePaz
 */
class adminController Extends baseController {
    //put your code here
    public function index() {
	$this->registry->template->show('admin/index');  
    }
}

?>
