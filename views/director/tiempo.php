<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
   	<title><?php echo $titulo; ?></title>
     <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
     <link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
     <style type="text/css">
  	.header_institucion {
		background-image: url("/reportes/views/images/logos/<?php echo $institucion->nombreCorto;?>-header.png");
		background-position: center;
		background-repeat: no-repeat;
		height: 150px;
		margin-top: -8px;
	}
	</style>
     <script type="text/javascript" src="/reportes/views/js/json.js"></script>
  	 <script type="text/javascript" src="/reportes/views/js/directorchart.js"></script>
  	 <script type="text/javascript" src="/reportes/views/js/googlecharts.js"></script>
     <script type="text/javascript">
     var chart;
     var data;
     function drawChart() {
   	  	document.getElementById("chart_div").innerHTML='';
   	  	document.getElementById("chart_nav").innerHTML='';
   	    data = new google.visualization.DataTable();
   	    data.addColumn('string', 'Sede');
   	    data.addColumn('number', 'Tiempo');
   	    data.addRows(<?php echo $arbol;?>);

   	    var options = {
   	      title: 'Tiempo de uso de la plataforma por sede',
   	      hAxis: {title: 'Sedes', titleTextStyle: {color: 'blue'}, viewWindowMode:'maximized'},
   	      vAxis: {title: 'minutos/alumnos', titleTextStyle: {color: 'blue'}, viewWindowMode:'explicit', viewWindow: {min:0}}
   	    };
   	    chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
   	    chart.draw(data, options);
   	    google.visualization.events.addListener(chart, 'select', loadCursos);
   	    
   	  }
     </script>
     <title>Informe para directores</title>
     <script type="text/javascript">
     google.load("visualization", "1", {packages:["corechart"]});
     google.setOnLoadCallback(drawChart);
     </script>
     
   </head>
   <body style="font-family: Arial;border: 0 none;">
   	<div class="header_institucion"></div>
    <div id="chart_div" style="width: 800px; height: 400px;">
    	<img class="loading-gif" border="0" src="/reportes/views/images/loading.gif" alt="cargando"/>
    </div>
    <div id="chart_nav"></div>
    <div id="detalleTiempo"></div>
    <div class="footer"></div>
   </body>
 </html>
