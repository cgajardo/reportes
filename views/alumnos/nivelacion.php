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
    <!-- javascript for ranking_curso -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Alumno');
        data.addColumn('number', 'Porcentaje de logro');
        data.addRows([
          <?php
          foreach ($notas_curso as $id => $nota){
          	if($id == count($notas_curso)-1){
          		echo '['.($id+1).', '.($nota->logro/100).']';}
          	else{
          		echo '['.($id+1).', '.($nota->logro/100).'],';}
          };
          for($sinnotas = count($notas_curso); $sinnotas < $total_estudiantes_curso; $sinnotas++){
          	echo ',['.($sinnotas+1).', 0]';
          }
          ?>
        ]);

        var options = {
          width: 800, height: 300,
          title: 'Ranking del Curso',
          hAxis: {showTextEvery: 1, gridlines:{count:10}},
          vAxis: {showTextEvery: 1, title: 'Porcentaje de Logro' , viewWindow: {min: 0},format:'#%'},
          pointSize: 5
        };

        var chart = new google.visualization.LineChart(document.getElementById('ranking_curso'));
        chart.draw(data, options);
      }
    </script>
    <!-- javascript for promedio_curso -->
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Caso');
        data.addColumn('number', 'Nota');
        data.addRows([
            ['Promedio Curso', <?php echo($logro_curso);?>],
            ['Estudiante', <?php echo($nota_alumno->logro);?>]
        ]);

        var options = {
            width: 500, height: 340,
            title: 'Comparativo Estudiante-Curso',
            vAxis: {showTextEvery: 1,viewWindow: {min: 0}, title: 'Porcentaje de Logro'}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('comparacion_curso'));
        chart.draw(data, options);
        }
    </script>  

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
  		Estimado Estudiante:<br/>
                <p align="justify">    A continuaci&oacute;n podr&aacute; ver su Matriz de Desempe&ntilde;o en el diagn&oacute;stico, en la cual se presentan los 
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
    		<td class="destacado">Logro &gt;= <?php echo $porcentaje_aprobado;?>%</td>
    		<td class="suficiente"><?php echo $porcentaje_suficiente;?>% &lt; Logro &lt;<?php echo $porcentaje_aprobado;?>%</td>
    		<td class="insuficiente">Logro &lt;= <?php echo $porcentaje_suficiente;?>%</td>
    		<td class="no_rendido">A&uacute;n no rendido</td>
    	</tr>
    	</table>
    </div>
    <hr/>
    Comparaci&oacute;n de su rendimiento con todos los estudiantes del curso que
    han rendido el diagn&oacute;stico hasta la fecha.
    <div id="ranking_curso" align="center"></div>
    Obtuviste un porcentaje de logro de <?php echo($nota_alumno->logro);?>% lo cual te ubica en el puesto N&deg;<?php echo $posicion_en_curso;?> 
    de un total de <?php echo $total_estudiantes_curso?> estudiantes en tu curso.
    <hr/>
    <div id="comparacion_curso" align="center"></div>
    Obtuvo <?php echo($nota_alumno->logro);?>% de logro, lo cual es
    <?php
    	if($nota_alumno->logro > $logro_curso){
    		echo 'mayor';
    	} elseif($nota_alumno->logro < $logro_curso){
    		echo 'menor';
    	} else{
    		echo 'igual';
    	} 
    	?> que el promedio del resto de los estudiantes, que fue de <?php echo($logro_curso);?>%.
    <hr/>
    
    <div class="center">
        <?php
            if(isset($reforzamiento)){
                echo '<h1 align="center">Actividades de nivelaci&oacute;n</h1>
                <p align="justify">Para cumplir con el objetivo de tener su matriz de desempe&ntilde;o con al menos un
                '.$porcentaje_aprobado.'% de logro en cada contenido (todo en verde), le sugerimos realizar durante 
                los pr&oacute;ximos 7 d&iacute;as las actividades detalladas al final de este reporte. Adem&aacute;s 
                le recomendamos seguir el orden de cada tema. Una vez que se sienta seguro, 
                debe realizar el control correspondiente al tema, para lo que tendr&aacute; tres 
                intentos y el sistema dejar&aacute; su mejor calificaci&oacute;n.</p><br/><br/>Actividades para los
                proximos 7 d&iacute;as:';
                echo '<table align="center">';
                asort($reforzamiento);
                $i=0;
                foreach($reforzamiento as $cont=>$reforzamiento_contenido){
                    if($i==3){
                        break;
                    }
                    echo '<tr><td><img src="../views/images/icons/check.png" align="center" width="40" heigth="50"></img></td><td>'.$cont.'</td>';
                    $i++;
                }
                echo '</table>';
            }else{
                echo '<h2>Felicitaciones tienes todos tus contenidos aprobados!!!</h2><br/>';
            }
        ?>
    </div>
    <div class="author">Reporte preparado por Galyleo para <?php echo ucwords($institucion->nombre);?></div>
    <div class="footer"></div>
  </body>
</html>