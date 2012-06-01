<html>
<head>
<?php 
	//revisamos si se trata de un update
	
	//calculamos los valores para el combo
	$combo = '<option value="-1">Seleccione una Instituci&oacute;n</option>';
	foreach ($instituciones as $institucion){
		if($institucion->id == $sede->idInstitucion )
			$combo.='<option selected value="'.$institucion->id.'">'.$institucion->nombre.'</option>';
		else
			$combo.='<option value="'.$institucion->id.'">'.$institucion->nombre.'</option>';
		
	}
?>
    <link rel="stylesheet" type="text/css" href="../views/styles/galyleo.css" />
</head>
<body align="center">
    <img class="header" src="../views/images/logos/galyleo.jpg">
<form action="<?php echo($_SERVER['PHP_SELF']);?>?rt=sedes/guardar" name="sede" method="post">
<?php
    if(isset($sede->id)){
            echo '<input type="hidden" name="id" value ="'.$sede->id.'"/>';
    }
?>
    <h1>Ingrese los Datos de la Sede</h1>
<table align="center">
<tr><td>Nombre</td> <td><input required type="text" name="nombre" value ="<?php echo $sede->nombre;?>"/></td></tr>

<tr><td>Pa&iacute;s </td><td><input type="text" name="pais" value ="<?php echo $sede->pais;?>"/></td></tr>

<tr><td>Regi&oacute;n </td><td><input type="text" name="region" value ="<?php echo $sede->region;?>"/></td></tr>

<tr><td>Ciudad </td><td><input type="text" name="ciudad" value ="<?php echo $sede->ciudad;?>"/></td></tr>

<tr><td>Instituci&oacute;n </td><td><select required type="text" name="institucion">
<?php 
echo $combo;
?>
</select></td></tr>
</table>	
<input type="submit" value="Guardar"/><br/>
<a href="<?php echo str_replace("index.php","",$_SERVER['PHP_SELF']);?>admin/index"><button>Volver</button></a>

</form>
    <div class="footer"></div>
</body>
</html>