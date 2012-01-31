<!DOCTYPE h1 PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
</head>
<body>
<h1>Todas tus evaluaciones</h1>
<p><?php $nombre=explode(" ",$usuario->nombre); echo ucwords(strtolower($nombre[0]));?> 
selecciona una evaluaci&oacute;n para revisar tus notas</p>
  
<?php
foreach($quizes as $quiz){
	
	if($quiz->fechaCierre > date("Y-m-f H:m:s")){
		echo $quiz->nombre.' (no finalizada)</br>';
	} else {
		echo '<a href="'.$_SERVER['PHP_SELF'].'?rt=reportes/index&params='.encode($origen.'&curso='.$id_curso.'&quiz='.$quiz->id).'">'.$quiz->nombre.'</a></br>';
	}
} 
echo '</br>';
echo '<a href="'.$_SERVER['PHP_SELF'].'?rt=reportes/index&params='.encode($origen).'">Volver</a>';

?>
</body>
</html>
