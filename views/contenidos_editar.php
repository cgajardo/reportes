<html>
<head>
</head>
<body>
<form action="contenidos/guardar" name="contenido" method="post">
Nombre<input type="text" name="nombre" value ="<?php echo $contenido->nombre;?>"/>
Link Repaso<input type="text" name="linkRepaso" value ="<?php echo $contenido->linkRepaso;?>"/>
Frase Logrado<input type="text" name="fraseLogrado" value ="<?php echo $contenido->fraseLogrado;?>"/>
Frase No Logrado<input type="text" name="fraseNoLogrado" value ="<?php echo $contenido->fraseNoLogrado;?>"/>
<input type="submit" value="Guardar"/>
</form>
</body>
</html>