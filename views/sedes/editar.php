<html>
<head>
</head>
<body>
<form action="<?php print($_SERVER['PHP_SELF']);?>?rt=sedes/guardar" name="sede" method="post">

Nombre <input type="text" name="nombre" value ="<?php echo $sede->nombre;?>"/>

Pa&iacute;s <input type="text" name="pais" value ="<?php echo $sede->pais;?>"/>

Regi&oacute;n <input type="text" name="region" value ="<?php echo $sede->region;?>"/>

Ciudad <input type="text" name="ciudad" value ="<?php echo $sede->ciudad;?>"/>
		
<input type="submit" value="Guardar"/>
</form>
</body>
</html>