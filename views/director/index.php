<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
     <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
     <link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
     <script type="text/javascript" src="/reportes/views/js/json.js"></script>
     <title>Informe para directores</title>
     <script type="php">
	 <?php
		foreach ($arbol['detalle'] as $key => $value){
			$data_sedes .= '["'.$key.'", '.$value['tiempo'].'],';
		}	 
	 ?>	
	 </script>
     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
     <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Sede');
        data.addColumn('number', 'Tiempo');
        data.addRows([<?php echo $data_sedes;?>]);

        var options = {
          width: 400, height: 240,
          title: 'Tiempo de uso de la plataforma por sede',
          hAxis: {title: 'Minutos', titleTextStyle: {color: 'blue'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        google.visualization.events.addListener(chart, 'select', loadXMLDoc);
        function selectHandler() {
			var selection = chart.getSelection();
        	var message = "";
        	for (var i = 0; i < selection.length; i++) {
        		var item = selection[i]; 
        	    if (item.row != null && item.column != null) {
        	    	message += 'Selecciono' + data['G'][item.column]['c'][0]['v'];
        	    } else if (item.row != null) {
        	        message += '{row:' + item.row + '}';
        	    } else if (item.column != null) {
        	        message += '{column:' + item.column + '}';
        	    }
        	}
        	chart.clearChart();
        	//se sobreescribe el gráfico 
        	chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

        	data = new google.visualization.DataTable();
            data.addColumn('string', 'Curso');
            data.addColumn('number', 'Tiempo');
            data.addRows([<?php echo $data_sedes;?>]);
            options = {
                    width: 800, height: 240,
                    title: 'Tiempo de uso de la plataforma por Curso',
                    hAxis: {title: 'Minutos', titleTextStyle: {color: 'blue'}}
            };
            
            chart.draw(data, options);
            google.visualization.events.addListener(chart, 'select', selectHandler);
        }

        function loadXMLDoc(){
        	var xmlhttp;
        	var id = 0;
        	var selection = chart.getSelection();
        	for (var i = 0; i < selection.length; i++) {
        		var item = selection[i]; 
        	    if (item.row != null && item.column != null) {
        	    	id = 3;
        	    } else if (item.row != null) {
        	    	id = 4;
        	    } else if (item.column != null) {
        	    	id = 3;
        	    }
        	}
        	
        	if (window.XMLHttpRequest){
            	// code for IE7+, Firefox, Chrome, Opera, Safari
          		xmlhttp=new XMLHttpRequest();
          	}
        	else{
            	// code for IE6, IE5
          		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          	}
        	xmlhttp.onreadystatechange=function() { 
          		if (xmlhttp.readyState==4 && xmlhttp.status==200){
          			document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
          			var j = JSON.parse(xmlhttp.responseText);
          			chart.clearChart();
                	//se sobreescribe el gráfico 
                	chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

                	data = new google.visualization.DataTable();
                    data.addColumn('string', 'Curso');
                    data.addColumn('number', 'Tiempo');
                    data.addRows(j);
                    options = {
                            width: 800, height: 240,
                            title: 'Tiempo de uso de la plataforma por Curso',
                            hAxis: {title: 'Minutos', titleTextStyle: {color: 'blue'}}
                    };
                    
                    chart.draw(data, options);
                    google.visualization.events.addListener(chart, 'select', selectHandler);
            	}
          	}
        	xmlhttp.open("GET","director/data?sede="+id,true);
        	xmlhttp.send();
        }
        
      }
    </script>
     
   </head>
   <body style="font-family: Arial;border: 0 none;">
     <div id="chart_div" style="width: 700px; height: 400px;"></div>
     <div id="myDiv"><h2>Let AJAX change this text</h2></div>
   </body>
 </html>