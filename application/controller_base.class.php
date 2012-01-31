<?php

Abstract Class baseController {

/*
 * @registry object
 */
protected $registry;
protected $encrypter;

function __construct($registry) {
	$this->registry = $registry;
	$this->encrypter = new Encrypter();
}

/**
 * @all controllers must contain an index method
 */
abstract function index();
}

?>
