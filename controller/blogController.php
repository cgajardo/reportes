<?php

Class blogController Extends baseController {

public function index() 
{
        $this->registry->template->blog_heading = 'This is the blog Index';
        $this->registry->template->show('blog_index');
}


public function view(){

	/*** should not have to call this here.... FIX ME ***/

	$this->registry->template->blog_heading = 'This is the blog heading';
	$this->registry->template->blog_content = 'This is the blog content';
	$this->registry->template->show('blog_view');
}

}
?>
