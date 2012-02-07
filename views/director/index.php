<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
 <html xmlns="http://www.w3.org/1999/xhtml">
   <head>
     <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
     <link rel="stylesheet" type="text/css" href="/reportes/views/styles/galyleo.css" />
     <script type="text/javascript" src="/reportes/views/js/json.js"></script>
     <script type="text/javascript" src="/reportes/views/js/directorchart.js"></script>
     <title>Informe para directores</title>
     <script type="php">
	 <?php
	 	$data_sedes = '[';
		foreach ($arbol['detalle'] as $key => $value){
			$data_sedes .= '["'.$key.'", '.$value['tiempo'].'],';
		}
		//quitamos el último caracter para evitarnos el , final
		$data_sedes = substr($data_sedes, 0, -1).']';
	 ?>	
	 </script>
     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
     <script type="text/javascript">
     google.load("visualization", "1", {packages:["corechart"]});
     google.setOnLoadCallback(drawChart);
     </script>
     
   </head>
   <body style="font-family: Arial;border: 0 none;">
     <div id="chart_div" style="width: 700px; height: 400px;"></div>
   </body>
 </html>