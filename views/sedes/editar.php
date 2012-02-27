<html>
<head>
    <link rel="stylesheet" type="text/css" href="./views/styles/galyleo.css" />
</head>
<body align="center">
    <img class="header" src="views/images/logos/galyleo.jpg">
<form action="<?php print($_SERVER['PHP_SELF']);?>?rt=sedes/guardar" name="sede" method="post">
    <h1>Ingrese los Datos de la Sede</h1>
<table align="center">
<tr><td>Nombre</td> <td><input type="text" name="nombre" value ="<?php echo $sede->nombre;?>"/></td></tr>

<tr><td>Pa&iacute;s </td><td><input type="text" name="pais" value ="<?php echo $sede->pais;?>"/></td></tr>

<tr><td>Regi&oacute;n </td><td><input type="text" name="region" value ="<?php echo $sede->region;?>"/></td></tr>

<tr><td>Ciudad </td><td><input type="text" name="ciudad" value ="<?php echo $sede->ciudad;?>"/></td></tr>
</table>	
<input type="submit" value="Guardar"/>

</form>
    <div class="footer"></div>
</body>
</html>