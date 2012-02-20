<html>
<head>
<title>Asociar contenido a pregunta</title>
<link rel="stylesheet" type="text/css" href="/reportes/views/styles/pagination.css"/>
<script type="text/javascript" src="/reportes/views/js/jquery_1.7.1.js"></script>
<script type="text/javascript">
function loadXMLDoc($id_contenido, $id_pregunta){
	var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById($id_pregunta).innerHTML=xmlhttp.responseText;
    	}
  	};
	xmlhttp.open("POST","<?php print($_SERVER['PHP_SELF']);?>?rt=contenidos/asociar_ajax&id_contenido="+$id_contenido+"&id_pregunta="+$id_pregunta,true);
	xmlhttp.send();
}
</script>
<?php include 'pagination.php';?>
<title>Asociar contenidos</title>
</head>
<body>
<a href="./asociar?filter=sin">Mostrar s&oacute;lo preguntas sin contenido</a><br/>
<a href="./asociar">Mostrar todas las preguntas</a>

<?php
$combo = 'name="contenido" onchange="loadXMLDoc(this.value, this.id)">';
$combo.='<option value="-1">Seleccione un Contenido</option>';
foreach ($contenidos as $contenido){
	$combo.='<option value="'.$contenido->id.'">'.$contenido->nombre.'</option>';
} 
$combo.='</select>';
?>
<div id="con_contenido">
<table class="paginable">
<tr>
	<th>Pregunta</th>
	<th>Contenido asociado</th>
	<th>Elegir otro contenido</th>
</tr>
<?php 
foreach($todas_las_preguntas as $pregunta){
	echo '<tr>';
	echo '<td>'.$pregunta->categoria->nombre.'</td>';
	echo '<td id="'.$pregunta->id.'">'.$pregunta->contenido->nombre.'</td>';
	echo '<td>'.'<select id="'.$pregunta->id.'" '.$combo.'</td>';
	echo '</tr>';
}
?>
</table>
<?php print pagination($page, $total);?>
</div>
</body>
</html>