<html>
<head>
<title><?php echo $title;?></title>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>
<body>
<div id="main"/>
<?php
	foreach($sedes as $sede){
		echo '<a href="'.$_SERVER['PHP_SELF'].'?rt=reportes/h&sede='.$sede->id.'" >'.$sede->nombre.'</a></br>';
	} 
?>
</body>
</html>
