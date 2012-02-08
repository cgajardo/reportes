<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
     <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
     <link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
     <script type="text/javascript" src="/reportes/views/js/json.js"></script>
  	 <script type="text/javascript" src="/reportes/views/js/directorchart.js"></script>
     <script type="text/javascript">
     var chart;
     var data;
     function drawChart() {
   	  	document.getElementById("chart_div").innerHTML='';
   	    data = new google.visualization.DataTable();
   	    data.addColumn('string', 'Sede');
   	    data.addColumn('number', 'Tiempo');
   	    data.addRows(<?php echo $arbol;?>);

   	    var options = {
   	      title: 'Tiempo de uso de la plataforma por sede',
   	      hAxis: {title: 'Sedes', titleTextStyle: {color: 'blue'}, viewWindowMode:'maximized'},
   	      vAxis: {title: 'minutos/alumnos', titleTextStyle: {color: 'blue'}}
   	    };
   	    chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
   	    chart.draw(data, options);
   	    google.visualization.events.addListener(chart, 'select', loadCursos);
   	    
   	  }
     </script>
     <title>Informe para directores</title>
     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
     <script type="text/javascript">
     google.load("visualization", "1", {packages:["corechart"]});
     google.setOnLoadCallback(drawChart);
     </script>
     
   </head>
   <body style="font-family: Arial;border: 0 none;">
     <div id="chart_div" style="width: 700px; height: 400px;">
     <img class="loading-gif" border="0" src="/reportes/views/images/loading.gif" alt="cargando"/>
     </div>
     <div id="chart_nav"></div>
   </body>
 </html>
