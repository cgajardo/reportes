<?php
// Is there a posted query string?
if(isset($_POST['queryString'])) {
	$likeString = $_POST['queryString'];
	
	if(strlen($likeString) >0) {
		// Run the query: We use LIKE '$queryString%'
		// The percentage sign is a wild-card, in my example of countries it works like this...
		// $queryString = 'Uni';
		// Returned data = 'United States, United Kindom';
		// YOU NEED TO ALTER THE QUERY TO MATCH YOUR DATABASE.
		// eg: SELECT yourColumnName FROM yourTable WHERE yourColumnName LIKE '$queryString%' LIMIT 10

		$matchContenidos = DAOFactory::getContenidosDAO()->getLike($likeString);
		foreach ($matchContenidos as $contenido) {
			// YOU MUST CHANGE: $result->value to $result->your_colum 
			echo '<li onClick="fill(\''.$contenido->nombre.'\',\''.$_POST['pregunta'].'\');">'.$contenido->nombre.'</li>';
		}
		
	} else {
		// Dont do anything.
	} // There is a queryString.
} else {
	echo 'There should be no direct access to this script!';
}
?>