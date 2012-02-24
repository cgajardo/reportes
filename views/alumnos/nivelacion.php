<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
  <title><?php echo $titulo; ?></title>
  	<link rel="stylesheet" type="text/css" href="../views/styles/galyleo.css" />
  	<style type="text/css">
  	.header_institucion {
		background-image: url("../views/images/logos/<?php echo $institucion->nombreCorto;?>-header.png");
		background-position: center;
		background-repeat: no-repeat;
		height: 150px;
		margin-top: -8px;
	}
	</style>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    </head>
  <body class="center">
  	<div class="header_institucion"></div>
  	<div class="title"><h1>Informe para el Estudiante</h1></div>
  	<div class="fecha_reporte"><?php echo fecha_hoy();?></div>
  	<div class="datos_alumno">
  		<b>Curso: </b><?php echo $nombre_curso ?></br>
  		<b>Estudiante: </b><?php echo ucwords(strtolower($usuario->nombre))." ". ucwords(strtolower($usuario->apellido)); ?>
  	</div>
  	<hr/>
  	<div class="descripcion">
  		<p>Estimado Estudiante:<br/>
                    A continuaci&oacute;n podr&aacute; ver su Matriz de Desempe&ntilde;o en el diagn&oacute;stico, en la cual se presentan los 
                contenidos medidos en esta evaluaci&oacute;n con sus respectivos porcentajes de logro. El objetivo es que 
                <b>antes del 23 de marzo del 2012</b> pueda transformar la matriz completa a verde. Para esto se le 
                indicar&aacute;n semanalmente qu&eacute; actividades debe realizar.</p>
  	</div> 
    <div class="subtitulo">Matriz de desempe&ntilde;o</div>
    <div id="matriz_desempeno">
    <?php
    	foreach($contenido_logro as $tema => $unidad){
    		$celdas = '';
    		$logro_quiz = 0;
    		$total_preguntas = 0;
    		foreach ($unidad as $contenido=>$celda){
    			$celdas .= '<tr>';
    			//nos permite identificar si el control fue rendido o no
    			if($celda == -1){
    				$celdas .= '<td class="no_rendido">'.$contenido.'</td>';
    			}elseif($celda <= 45){
                                $reforzamiento[$contenido] = $unidad[$contenido];
    				$celdas .= '<td class="insuficiente">'.$contenido.' ('.round($celda).'%)</td>';
    			}elseif($celda > 45 && $celda < 55 ){
                                $reforzamiento[$contenido] = $unidad[$contenido];
    				$celdas .= '<td class="suficiente">'.$contenido.' ('.round($celda).'%)</td>';
    			}elseif ($celda >= 55){
    				$celdas .= '<td class="destacado">'.$contenido.' ('.round($celda).'%)</td>';
    			}else{
    				$celdas .= '<td class="no_rendido">'.$contenido.' ('.round($celda).'%)</td>';
    			}
    			$celdas .= '</td>';
    			$logro_quiz += $celda['logro']*$celda['numero_preguntas'];
    			$total_preguntas += $celda['numero_preguntas'];
    		}
    		
    		echo '<table class="matriz">';
    		echo '<tr><td class="header">';
    		// caso de quiz no rendido
    		echo $tema;
    		echo '</td></td>';
    		echo $celdas;
    		echo '</table>';	
    	} 
    ?>
    </div>
    <div>
    	<table class="leyenda">
    	<tr>
    		<td class="destacado">Logro &gt;= 55%</td>
    		<td class="suficiente">45% &lt; Logro &lt;55%</td>
    		<td class="insuficiente">Logro &lt;= 45%</td>
    		<td class="no_rendido">A&uacute;n no rendido</td>
    	</tr>
    	</table>
    </div>
    <div class="center">
        <?php
            if(isset($reforzamiento)){
                echo '<h2>Debes reforzar los siguientes contenidos:</h2><br/>';
                asort($reforzamiento);
                $i=0;
                foreach($reforzamiento as $cont=>$reforzamiento_contenido){
                    if($i==3){
                        break;
                    }
                    echo '<li>'.$cont.'</li>';
                    $i++;
                }
            }else{
                echo '<h2>Felicitaciones tienes todos tus contenidos aprobados!!!</h2><br/>';
            }
        ?>
    </div>
    <div class="author">Reporte preparado por Galyleo para <?php echo ucwords($institucion->nombre);?></div>
    <div class="footer"></div>
  </body>
</html>