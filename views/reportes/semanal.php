<html>
  <head>
  <title><?php echo $titulo; ?></title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!-- javascript for ranking_curso -->
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Alumno');
        data.addColumn('number', 'Puntaje');
        data.addRows([
          <?php
          foreach ($notas_grupo as $id => $nota){
          	if($id == count($notas_grupo)-1){
          		echo '['.$id.', '.$nota->logro.']';}
          	else{
          		echo '['.$id.', '.$nota->logro.'],';}
          };
          for($sinnotas = count($notas_grupo); $sinnotas < $total_estudiantes_grupo; $sinnotas++){
          	echo ',['.$sinnotas.', 0]';
          }
          ?>
        ]);

        var options = {
          width: 400, height: 240,
          title: 'Ranking del Curso',
          hAxis: {showTextEvery: 1, showTextEvery:1,gridlines:{count:10}},
          vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
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
          width: 400, height: 240,
          vAxis: {showTextEvery: 1,viewWindow: {min: 0}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('comparacion_grupo'));
        chart.draw(data, options);
      }
    </script>  
  </head>
  <body>
  	<h1>Informe Semanal para el Estudiante</h1>
  	<!-- TODO: mostrar la fecha de hoy -->
  	<b>Curso: </b><?php echo $nombre_curso ?></br>
  	<b>Estudiante: </b><?php echo ucwords(strtolower($usuario->nombre))." ". ucwords(strtolower($usuario->apellido)); ?></br>
  	<hr/>
  	<p>Estimado alumno:</br>A continuaci&oacute;n podr&aacute;s ver tu matriz de desempe&ntilde;o en las evaluaciones rendidas a la fecha
  	y acontinuaci&oacute; los resultados de la &uacute;ltima actividad</p> 
    <!--Div that will hold the pie chart-->
    <b>Matriz de desempe&ntilde;o</b>
    </br>
    <style type="text/css" media="screen">
 		table { border: 1px solid black;float:left;width:148px;}
 		#matriz_desempeno{width:800px;margin:0;overflow:hidden;}
	</style>
    <div id="matriz_desempeno">
    <?php
    	foreach($matriz_desempe–o as $quiz => $columna){
    		$celdas = '';
    		$logro_quiz = 0;
    		$total_preguntas = 0;
    		foreach ($columna as $celda){
    			$celdas .= '<tr>';
    			if($celda['logro'] < 60){
    				$celdas .= '<td class="reprueba">'.$celda['contenido']->nombre.'('.$celda['logro'].'%)</td>';
    			}else{
    				$celdas .= '<td>'.$celda['contenido']->nombre.'('.$celda['logro'].'%)</td>';
    			}
    			$celdas .= '</td>';
    			$logro_quiz += $celda['logro']*$celda['numero_preguntas'];
    			$total_preguntas += $celda['numero_preguntas'];
    		}
    		
    		echo '<table>';
    		echo '<tr><td><b>';
    		echo $quiz.'('.round($logro_quiz/$total_preguntas).'%)';
    		echo '</b></td></td>';
    		echo $celdas;
    		echo '</table>';	
    	} 
    ?>
    </div>
    <hr/>
    <div id="mensajes_personalizados">
    	<?php
    		foreach ($contenido_logro as $data){
     			echo "Tu porcentaje de logro est&aacute; ";
     			if($data['logro']>=60){
     				echo "por sobre el 60% en ".$data['contenido']->nombre.":</br>";
     				echo $data['contenido']->fraseLogrado.".</br>";
     			} else{
     				echo "bajo el 60% en ".$data['contenido']->nombre.":</br>";
     				echo $data['contenido']->fraseNoLogrado.". Re recomendamos visitar: ".$data['contenido']->linkRepaso.".</br>";
     			}
     		}
     	?>
    </div>
    <br/>
    <hr/>
    <div class="comparacion_grupo">
    <p>Seg&uacute;n lo que respondiste en la actividad <?php echo $nombre_actividad;?>, cerrada el d&iacute;a <?php echo $fecha_cierre;?>, tus resultados son los siguientes:</p>
    <div id="ranking_curso"></div>
    <p>Obtuviste un porcentaje de logro de <?php echo($nota_alumno->logro);?>% lo cual te ubica en el puesto N&deg;<?php echo $posicion_en_grupo;?> 
    de un total de <?php echo $total_estudiantes_grupo?> estudiantes en tu curso. 
    <hr/>
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
    	?> que el promedio de tu curso, el cual fue <?php echo($promedio_grupo);?></p>
    <hr/>
    </div>
  </body>
</html>