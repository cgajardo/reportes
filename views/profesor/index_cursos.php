<!DOCTYPE h1 PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo $titulo;?></title>
	<link rel="stylesheet" type="text/css" href="views/styles/galyleo.css" />
  	<style type="text/css">
  	.header_institucion {
		background-image: url("views/images/logos/<?php echo $institucion->nombreCorto;?>-header.png");
		background-position: center;
		background-repeat: no-repeat;
		height: 150px;
		margin-top: -8px;
	}
	</style>
</head>
<body>
	<div class="header_institucion"></div>
	<h1>Todos tus cursos</h1>
	<p> Bienvenido <?php echo ucwords(strtolower($usuario->nombre));?> 
	a continuaci&oacute;n podr&aacute;s revisar el historial de evaluaciones y notas de tus cursos. </br>
	Por favor selecciona el curso que deseas revisar </p>
	  
	<?php
	foreach($cursos as $curso){
            $grupos =  DAOFactory::getGruposDAO()->getGrupoByCursoAndProfesor($usuario->id, $curso->id);
            //var_dump($grupos);
            foreach($grupos as $grupo){
                
                //var_dump($_SERVER['PHP_SELF']);
                if($curso->nivelacion == 1){
                    echo '<a href="profesores/nivelacion?params='.$encrypter->encode('&curso='.$curso->id.'&grupo='.$grupo->id).'">'.$curso->nombre.'-'.$grupo->nombre.'</a></br>';	
                }else{
                    echo '<a href="profesores/index?params='.$encrypter->encode('&curso='.$curso->id.'&grupo='.$grupo->id).'">'.$curso->nombre.'-'.$grupo->nombre.'</a></br>';	
                }
            }
	} 
	echo '</br>';
	?>

    <div class="footer"></div>
</body>
</html>