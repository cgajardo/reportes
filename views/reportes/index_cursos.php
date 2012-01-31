<!DOCTYPE h1 PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
</head>
<body>
<h1>Todos tus cursos</h1>
<p> Bienvenido <?php echo ucwords(strtolower($usuario->nombre));?> 
a continuaci&oacute;n podr&aacute;s revisar tu historial de evaluaciones y notas. </br>
Por favor selecciona el curso que deseas revisar </p>
  
<?php
foreach($cursos as $curso){
	echo '<a href="'.$_SERVER['PHP_SELF'].'?rt=reportes/index&params='.$encrypter->encode($origen.'&curso='.$curso->id).'">'.$curso->nombre.'</a></br>';	
} 
echo '</br>';
?>

</table>
</body>
</html>
