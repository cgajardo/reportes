<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $titulo;?></title>
</head>
<body>
<h1>Detalle evaluaci&oacute;n</h1>
<p>Los contenidos evaluados y tu logro se muestran a continuaci&oacute;n:</p>
<h2>Tu nota en esta evaluaci&oacute;n corresponde a un <?php echo $nota[0]->nota;?> </h2>
<table>
<tr>
<th>Contenido</th>
<th>n&uacute;mero de preguntas</th>
<th>% Logro</th>
</tr>
<?php
	
	foreach($contenido_logro as $contenido){
		echo '<tr>';
		echo '<td>'.$contenido['contenido']->nombre.'</td>';
		echo '<td>'.$contenido['numero_preguntas'].'</td>';
		echo '<td>'.$contenido['logro'].'%</td>';
		echo '</tr>';
	}
?>
</table>
</br>
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']).'reportes/index';?>">Volver</a>
</body>
</html>

