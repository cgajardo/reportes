<html>
<head>
<title>Asociar contenido a pregunta</title>
<link rel="stylesheet" type="text/css" href="../views/styles/pagination.css"/>
<script type="text/javascript" src="/reportes/views/js/jquery_1.7.1.js"></script>
<script type="text/javascript" charset="utf-8">

function asociarCurso(curso, sede){
        var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		cursos();
                
    	}
  	};
        xmlhttp.open("POST","asociarCurso?curso="+curso+"&sede="+sede,true);
	xmlhttp.send();
}

function asociarGrupo(grupo, sede){
        var xmlhttp;
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById("grupo"+grupo).innerHTML=xmlhttp.responseText;
    	}
  	};
        xmlhttp.open("POST","asociarGrupo?grupo="+grupo+"&sede="+sede,true);
	xmlhttp.send();
}

function cursos(){
    var curso = document.getElementById("curso").value;
    if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else{// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}
	xmlhttp.onreadystatechange=function(){
  		if (xmlhttp.readyState==4 && xmlhttp.status==200){
    		document.getElementById("grupos").innerHTML=xmlhttp.responseText;
    	}
  	};
        xmlhttp.open("POST","grupos?curso="+curso,true);
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
$combo =' onchange="asociar(this.value,this.id)"><option value="-1">Seleccione una Sede</option>';
foreach($sedes as $sede){
    $combo.='<option value="'.$sede->id.'">'.$sede->nombre.'</option>';
}
?>
        <br><br><b>Cursos: </b>
        <select id="curso" onchange="cursos()">
            <option>Seleccione un curso</option>
            <?php
                foreach($cursos as $curso){
                    echo '<option value="'.$curso->id.'">'.utf8_decode($curso->nombre).'</option>';
                }
            ?>
        </select>
    </div>
    <div id="grupos"></div>
    <br><br>
    <div class="footer"></div>
</body>
</html>
