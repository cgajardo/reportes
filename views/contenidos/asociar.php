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

function load($padre,$categoria){
    
        var xmlhttp;
        if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
        }
        else{// code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState==4 && xmlhttp.status==200){
                document.getElementById("cat"+$padre).innerHTML=xmlhttp.responseText;
        }
        };
        xmlhttp.open("GET","load_categoria?categoria="+$categoria,true);
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
        <table>
            <tr><th colspan="2"><select id="0" name="categoria" onchange="load(0,this.value)">
                        <option value="-1">SELECCIONE CATEGORIA</option>
                <?php 
                    foreach ($categorias as $categoria) {
                        echo '<option value="'.$categoria->id.'">'.$categoria->nombre.'</option>';
                    }
                ?>
            </select></th></tr>
            <tr><td></td><td><div id="cat0"></div></td></tr>
        </table>
    </div>
<div class="footer"></div>
</body>
</html>