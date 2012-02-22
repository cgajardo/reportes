<?php

Abstract Class baseController {

/*
 * @registry object
 */
protected $registry;
protected $encrypter;
protected $mailer;

function __construct($registry) {
	$this->registry = $registry;
	$this->encrypter = new Encrypter();
	$this->mailer = new Mailer();
}

/**
 * @all controllers must contain an index method
 */
abstract function index();
}

?>