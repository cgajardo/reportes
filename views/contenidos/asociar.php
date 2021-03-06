<html>
<head>
<title>Asociar contenido a pregunta</title>
<link rel="stylesheet" type="text/css" href="../views/styles/pagination.css"/>
<script type="text/javascript" src="/reportes/views/js/jquery_1.7.1.js"></script>
<script type="text/javascript" charset="utf-8">

function asociar($id_contenido, $id_pregunta){
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
        xmlhttp.open("POST","asociar_ajax?id_contenido="+$id_contenido+"&id_pregunta="+$id_pregunta,true);
	xmlhttp.send();
}

function loadPadres($id_contenido, $id_pregunta){
   var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('padres'+$id_pregunta).innerHTML=xmlhttp.responseText;
		}
	};
	xmlhttp.open("POST","contenidos_padres?contenido="+$id_contenido+"&pregunta="+$id_pregunta,true);
	xmlhttp.send();
}

function loadHijos($id_contenido, $id_pregunta){
    var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('hijos'+$id_pregunta).innerHTML=xmlhttp.responseText;
		}
	};
	xmlhttp.open("POST","contenidos_hijos?contenido="+$id_contenido+"&pregunta="+$id_pregunta,true);
	xmlhttp.send();
}

function preguntas(){
    var quiz=document.getElementById("quiz").value;
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById("preguntas").innerHTML=xmlhttp.responseText;
    	}
  	};
        xmlhttp.open("POST","preguntas_quiz?quiz="+quiz,true);
	xmlhttp.send();
}
</script>
<style>
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
$combo ='id="quiz" onchange="preguntas()"><option value="-1">Seleccione un Quiz</option>';
foreach($quizesByCurso as $quizes){
    $combo.='<optgroup label="'.$quizes[0]->nombre.'">';
    foreach($quizes[1] as $quiz){
        $combo .= '<option value="'.$quiz->id.'">'.$quiz->nombre.'</option>';
    }
    $combo.='</optgroup>';
}
echo '<select '.$combo.'</select>';
?>
        <br><br><b>PREGUNTAS DEL QUIZ: </b>
    <div id="preguntas"></div>
    </div>
    <br><br>
    <div class="footer"></div>
</body>
</html>
