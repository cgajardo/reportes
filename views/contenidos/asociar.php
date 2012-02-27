<html>
<head>
<title>Asociar contenido a pregunta</title>
<link rel="stylesheet" type="text/css" href="/reportes/views/styles/pagination.css"/>
<script type="text/javascript" src="/reportes/views/js/jquery_1.7.1.js"></script>
<script type="text/javascript" charset="utf-8">
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

function buscar(){
    
        var pat=document.getElementById("pat").value;
        if(pat!=""){
            var xmlhttp;
            if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
            }
            else{// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function(){
                    if (xmlhttp.readyState==4 && xmlhttp.status==200){
                    document.getElementById("con_contenido").innerHTML=xmlhttp.responseText;
            }
            };
            xmlhttp.open("GET","<?php print($_SERVER['PHP_SELF']);?>?rt=contenidos/buscar_ajax&patron="+pat,true);
            xmlhttp.send();
        }
}
</script>
<style>
    .header {
        height: 150px;
        margin-top: -8px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<?php include 'pagination.php';?>
<title>Asociar contenidos</title>
</head>
<body align="center">
    <img class="header" src="../views/images/logos/galyleo.jpg"><br/><br/>
    <div align="left">
<a href="./asociar?filter=sin">Mostrar s&oacute;lo preguntas sin contenido</a><br/>
<a href="./asociar">Mostrar todas las preguntas</a>
<br/>

<?php
$combo = 'name="contenido" onchange="loadXMLDoc(this.value, this.id)">';
$combo.='<option value="-1">Seleccione un Contenido</option>';
foreach ($contenidos as $contenido){
	$combo.='<option value="'.$contenido->id.'">'.$contenido->nombre.'</option>';
} 
$combo.='</select>';
?>
BUSCAR PREGUNTA <input id="pat"><input type="button" onclick="buscar()" value="BUSCAR">
    </div>
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
	echo '<td>'.$pregunta->nombre.'</td>';
        if ($pregunta->contenido) {
            echo '<td id="'.$pregunta->id.'">'.$pregunta->contenido->nombre.'</td>';
        }else{
            echo '<td id="'.$pregunta->id.'"></td>';
        }
	echo '<td>'.'<select id="'.$pregunta->id.'" '.$combo.'</td>';
	echo '</tr>';
}
?>
</table>
<?php print pagination($page, $total);?>
</div>
<div class="footer"></div>
</body>
</html>