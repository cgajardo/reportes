<html>
<head>
<title>Asociar contenido a pregunta</title>
<link rel="stylesheet" type="text/css" href="/reportes/views/styles/pagination.css"/>
<script type="text/javascript" src="/reportes/views/js/jquery_1.7.1.js"></script>
<script type="text/javascript" charset="utf-8">
function asociar(){
        var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById("editar").innerHTML="";
    		document.getElementById("editar").hidden="true";
                
    	}
  	};
        xmlhttp.open("POST",".",true);
	xmlhttp.send();
}

function ocultar(){
    document.getElementById("editar").hidden="true";
    document.getElementById("editar").innerHtml="";
}

function calendario(){
    var curso=document.getElementById("cursos").value;
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById("calendario").innerHTML=xmlhttp.responseText;
    	}
  	};
        xmlhttp.open("POST","calendario_curso?curso="+curso,true);
	xmlhttp.send();
}

function editar(fechaInicio,fechaCierre){
    var curso=document.getElementById("cursos").value;
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById("editar").innerHTML=xmlhttp.responseText;
    		document.getElementById("editar").hidden="";
                
    	}
  	};
        xmlhttp.open("POST","editar_actividad?curso="+curso+"&fechaInicio="+fechaInicio+"&fechaCierre="+fechaCierre,true);
	xmlhttp.send();

}

</script>
<style>
    .editar{
        position: fixed;
        margin-left: 300px;
        margin-top: -20px;
        background-color: #AAA;        
    }
    
    .header {
        height: 150px;
        margin-top: -8px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .footer {
	background-image: url("/reportes/views/images/logos/footer.png");
	background-position: center;
	background-repeat: no-repeat;
	height: 68px;
	margin-bottom:-8px;
	 	
}
</style>

<title>Asociar contenidos</title>
</head>
<body align="center">
    <img class="header" src="../views/images/logos/galyleo.jpg"><br/><br/>
    <div align="left" style="margin-left:112px">
        <br/>
<?php
$combo ='id="cursos" onchange="calendario()"><option value="-1">Seleccione un Curso</option>';
foreach($cursosBySede as $nombre=>$cursos){
    $combo.='<optgroup label="'.$nombre.'">';
    foreach ($cursos as $curso){
        $combo.='<option value="'.$curso->id.'"';
        if(@$idCurso && $idCurso = $curso->id){
            $combo.= ' selected';
        }
        $combo.='>'.$curso->nombre.'</option>';
    }
    $combo.='</optgroup>';
}
echo '<select '.$combo.'</select>';
?>
        <script>calendario()</script>
        <div id="editar" class="editar" hidden></div>
        <br><br>
    <div id="calendario"></div>
    </div>
    
    <br><br>
    <div class="footer"></div>
</body>
</html>
