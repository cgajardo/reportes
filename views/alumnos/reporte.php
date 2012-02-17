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
          foreach ($notas_grupo as $id => $nota){
          	if($id == count($notas_grupo)-1){
          		echo '['.($id+1).', '.($nota->logro/100).']';}
          	else{
          		echo '['.($id+1).', '.($nota->logro/100).'],';}
          };
          for($sinnotas = count($notas_grupo); $sinnotas < $total_estudiantes_grupo; $sinnotas++){
          	echo ',['.$sinnotas.', 0]';
          }
          ?>
        ]);

        var options = {
          width: 800, height: 300,
          title: 'Ranking del Curso',
          hAxis: {showTextEvery: 1, showTextEvery:1,gridlines:{count:10}},
          vAxis: {showTextEvery: 1,viewWindow: {min: 0},format:'#%'},
          pointSize: 5
        };

        var chart = new google.visualization.LineChart(document.getElementById('ranking_curso'));
        chart.draw(data, options);
      }
    </script>
	<!-- javascript for comparacion promedio -->
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Caso');
        data.addColumn('number', 'Nota');
        data.addRows([
          ['Promedio Curso', <?php echo($promedio_grupo);?>],
          ['Nota Alumno', <?php echo($nota_alumno->nota);?>]
        ]);

        var options = {
          width: 500, height: 340,
          vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('comparacion_grupo'));
        chart.draw(data, options);
      }
    </script>  
	<!--  javascript para el tiempo en plataforma -->
	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Fecha');
        data.addColumn('number', 'Minutos');
        data.addRows([
          <?php 
          	foreach (array_reverse($tiempos_semanas) AS $fecha => $tiempo){
          		echo '["'.$fecha.'",'.round($tiempo/60,1).'],';
          	}
          ?>	
        ]);

        var options = {
          width: 800, height: 300,
          title: 'Tiempo por semana'
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('tiempo_semana'));
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
  		<p>Estimado alumno:</br>A continuaci&oacute;n podr&aacute;s ver tu matriz de 
  		desempe&ntilde;o en las evaluaciones rendidas a la fecha</p>
  	</div> 
    <div class="subtitulo">Matriz de desempe&ntilde;o</div>
    <div id="matriz_desempeno">
    <?php
    	foreach($matriz_desempeño as $quiz => $columna){
    		$celdas = '';
    		$logro_quiz = 0;
    		$total_preguntas = 0;
    		
    		foreach ($columna as $celda){
    			$celdas .= '<tr>';
    			//nos permite identificar si el control fue rendido o no
    			if($celda['logro'] == -1){
    				$celdas .= '<td class="no_rendido">'.$celda['contenido']->nombre.'</td>';
    			}elseif($celda['logro'] <= 45){
    				$celdas .= '<td class="insuficiente">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
    			}elseif($celda['logro'] > 45 && $celda['logro'] < 55 ){
    				$celdas .= '<td class="suficiente">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
    			}elseif ($celda['logro'] >= 55){
    				$celdas .= '<td class="destacado">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
    			}else{
    				$celdas .= '<td class="no_rendido">'.$celda['contenido']->nombre.' ('.round($celda['logro']).'%)</td>';
    			}
    			$celdas .= '</td>';
    			$logro_quiz += $celda['logro']*$celda['numero_preguntas'];
    			$total_preguntas += $celda['numero_preguntas'];
    		}
    		
    		echo '<table class="matriz">';
    		echo '<tr><td class="header">';
    		// caso de quiz no rendido
    		if ($total_preguntas == 0){
    			echo $quiz.' (-)';
    		}else{
    			echo $quiz.' ('.round($logro_quiz/$total_preguntas).'%)';
    		}
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
    <div class="subtitulo">Nivel de logro</div>
    <div class="contador">
    	<table class="contador">
    	<tr>
    		<th>Actividad</th>
    		<th>Contenidos Logrados</th>
    		<th>Contenidos No Logrados</th>
    	</tr>
    		<?php
			foreach($matriz_desempeño as $quiz => $columna){
	    		$logrados = 0;
	    		$no_logrado = 0;
	    		
	    		foreach ($columna as $celda){
	    			//TODO: cuentan los controles no rendidos?
	    			if($celda['logro'] == -1){
	    				$no_logrado++;	
	    			}elseif ($celda['logro'] >= 55){
	    				$logrados++;
	    			}else{
	    				$no_logrado++;
	    			}
	    		}
	    		
	    		echo '<tr>';
	    		echo '<td>'.$quiz.'</td>';
	    		echo '<td>'.$logrados.'</td>';
	    		echo '<td>'.$no_logrado.'</td>';
	    		echo '</tr>';	
	    	}
    	?>
    	</table>
    </div>
    <div class="hr"></div>
    <p>Tus resultados en la actividad <?php echo $nombre_actividad;?> indican que:</p>
    <div id="mensajes_personalizados">
    	<?php
    		foreach ($contenido_logro as $data){
     			if($data['logro']>=55){
     				echo '<div class="mensaje_suficiente"> Tu porcentaje de logro est&aacute; ';
     				echo "por sobre el 55% en ".$data['contenido']->nombre.":</br>";
     				echo $data['contenido']->fraseLogrado.".</br>";
     			} else{
     				echo '<div class="mensaje_insuficiente"> Tu porcentaje de logro est&aacute; ';
     				echo "bajo el 55% en ".$data['contenido']->nombre.":</br>";
     				echo $data['contenido']->fraseNoLogrado.". Te recomendamos visitar: ".$data['contenido']->linkRepaso.".</br>";
     			}
     			echo '</div>';
     		}
     	?>
    </div>
    <br/>
    <div class="hr"></div>
    <div class="comparacion_grupo">
    <p>Seg&uacute;n lo que respondiste en la actividad <?php echo $nombre_actividad;?>, cerrada el d&iacute;a <?php echo $fecha_cierre;?>, tus resultados son los siguientes:</p>
    <div id="ranking_curso"></div>
    <p>Obtuviste un porcentaje de logro de <?php echo($nota_alumno->logro);?>% lo cual te ubica en el puesto N&deg;<?php echo $posicion_en_grupo;?> 
    de un total de <?php echo $total_estudiantes_grupo?> estudiantes en tu curso. 
    <div class="hr"></div>
    <div id="comparacion_grupo"></div>
    <p>Obtuviste un <?php echo($nota_alumno->nota);?>, lo cual es
    <?php
    	if($nota_alumno->nota > $promedio_grupo){
    		echo 'mayor';
    	} elseif($nota_alumno->nota < $promedio_grupo){
    		echo 'menor';
    	} else{
    		echo 'igual';
    	} 
    	?> que el promedio de tu curso, el cual fue <?php echo($promedio_grupo);?>.</p>
    <div class="hr"></div>
    <p>El siguiente gr&aacute;fico muestra el tiempo que dedicaste a la plataforma durante las &uacute;ltimas 10 semanas.
    <div id="tiempo_semana"></div>
    </div>
    <div class="author">Reporte preparado por Galyleo para <?php echo ucwords($institucion->nombre);?></div>
    <div class="footer"></div>
  </body>
</html>