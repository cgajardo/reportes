<html>
  <head>
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
          	if($id == count($notas_grupo)){
          		echo '['.$id.', '.$nota->logro.']';}
          	else{
          		echo '['.$id.', '.$nota->logro.'],';}
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
  	<b>Curso: </b><?php echo $usuario->nombre ?></br>
  	<b>Estudiante: </b><?php echo $usuario->apellido ?></br>
  	<b>RUT:</b>
  	<hr/>
  	<p>Estimado alumno:</br>A continuaci&oacute;n podr&aacute;s ver tu matriz de desempe&ntilde;o en las evaluaciones rendidas a la fecha
  	y en las p&aacute;ginas siguientes encontrar&aacute;s los resultados de la &uacute;ltima actividad</p> 
    <!--Div that will hold the pie chart-->
    <b>TODO: tabla por contenido</b>
    <hr/>
    <p>Seg&uacute;n lo que respondiste en la actividad <?php echo $nombre_actividad;?>, cerrada el d&iacute;a <?php echo $fecha_cierre;?>, tus resultados son los siguiente:</p>
    <div id="ranking_curso"></div>
    <p>Obtuviste un porcentaje de logro de <?php echo($nota_alumno->logro);?>% lo cual te ubica en el puesto N&deg;<?php echo $posicion_en_grupo;?> 
    de un total de <?php echo $total_personas_grupo?> estudiantes en tu curso. 
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
    TODO:logro por contenidos
  </body>
</html>