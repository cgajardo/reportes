<html>
<head>
<link rel="stylesheet" type="text/css" href="/reportes/views/styles/pagination.css"/>
<script type="text/javascript" src="/reportes/views/js/jquery_1.7.1.js"></script>

<script type="text/javascript">
	function lookup(inputString, pregunta) {
		if(inputString.length == 0) {
			// Hide the suggestion box.
			$('#suggestions').hide();
		} else {
			$.post("autocompletar", {queryString: ""+inputString+"",pregunta: ""+pregunta+"" }, function(data){
				if(data.length >0) {
					$('#suggestions').show();
					$('#autoSuggestionsList').html(data);
				}
			});
		}
	} // lookup
	
	function fill(thisValue, idPregunta) {
		$('#'.idPregunta).val(thisValue);
		setTimeout("$('#suggestions').hide();", 200);
	}
</script>

<style type="text/css">
	body {
		font-family: Helvetica;
		font-size: 11px;
		color: #000;
	}
	
	h3 {
		margin: 0px;
		padding: 0px;	
	}

	.suggestionsBox {
		position: relative;
		left: 30px;
		margin: 10px 0px 0px 0px;
		width: 200px;
		background-color: #212427;
		-moz-border-radius: 7px;
		-webkit-border-radius: 7px;
		border: 2px solid #000;	
		color: #fff;
	}
	
	.suggestionList {
		margin: 0px;
		padding: 0px;
	}
	
	.suggestionList li {
		
		margin: 0px 0px 3px 0px;
		padding: 3px;
		cursor: pointer;
	}
	
	.suggestionList li:hover {
		background-color: #659CD8;
	}
</style>

<!--  end test -->
<?php include 'pagination.php';?>

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
    		//document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    	}
  	}
	xmlhttp.open("POST","<?php print($_SERVER['PHP_SELF']);?>?rt=contenidos/asociar_ajax&id_contenido="+$id_contenido+"&id_pregunta="+$id_pregunta,true);
	xmlhttp.send();
}
</script>
<title>Asociar contenidos</title>
</head>
<body>
<div>
		<form>
			<div>
				Type your county:
				<br />
				<input type="text" size="30" value="" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" />
			</div>
			
			<div class="suggestionsBox" id="suggestions" style="display: none;">
				<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
				<div class="suggestionList" id="autoSuggestionsList">
					&nbsp;
				</div>
			</div>
		</form>
	</div>


<div id="sin_cotenido"/>
<table>
<?php
$combo = 'name="contenido" onchange="loadXMLDoc(this.value, this.id)">';
$combo.='<option value="-1">Seleccione un Contenido</option>';
foreach ($contenidos as $contenido){
	$combo.='<option value="'.$contenido->id.'">'.$contenido->nombre.'</option>';
} 
$combo.='</select>';
?>
<?php 
// foreach($preguntas_sin_asociar as $pregunta){
// 	echo '<tr>';
// 	echo '<td>'.$pregunta->categoria->nombre.'</td>';
// 	echo '<td>'.'<select id="'.$pregunta->id.'" '.$combo.'</td>';
// 	echo '</tr>';
// }
?>
</table>

</div>
<div id="con_contenido">
<table>
<?php 
foreach($todas_las_preguntas as $pregunta){
	echo '<tr>';
	echo '<td>'.$pregunta->categoria->nombre.'</td>';
	echo '<td>'.$pregunta->contenido->nombre.'</td>';
	echo '<td>';
	echo '<input type="text" size="30" value="'.$pregunta->contenido->nombre.'" id="'.$pregunta->id.'" onkeyup="lookup(this.value, '.$pregunta->id.');" onblur="fill();" />';
	echo '<div class="suggestionsBox" id="suggestions" style="display: none;">';
	echo '<img src="upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />';
	echo '<div class="suggestionList" id="autoSuggestionsList">';
	echo '&nbsp;';
	echo '</div>';
	echo '</div>';
	echo '</td>';
	echo '<td>'.'<select id="'.$pregunta->id.'" '.$combo.'</td>';
	echo '</tr>';
}
?>
</table>
<?php print pagination($page, $total);?>
</div>
</body>
</html>