<b>Nombres:</b> <?php echo $nombre_usuario;?></br>
<b>Apellidos:</b> <?php echo $apellido_usuario;?></br>
<h1><?php echo $reporte_main; ?></h1>
<p>Quizes rendidos:</p></br>
<table>
  <tr>
    <th>Id</th>
    <th>Nombre</th>
  </tr>
  
<?php
foreach($quizes as $quiz){
	
	echo '<tr>';
    echo '<td>'.$quiz->id.'</td>';
    echo '<td>'.$quiz->nombre.'</td>';
  	echo '</tr>';	
} 
?>

</table>