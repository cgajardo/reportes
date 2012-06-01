<?php
/**
*
*/

function getOrAddCategoria($category_id, $connectionLocal, $conectionMoodle){
	global $CURRENT;
	global $PREFIX;
	global $IDPLATAFORM;
	
	$query = 'SELECT id FROM categorias WHERE identificador_moodle="'.$CURRENT.'_'.$category_id.'"';
	$categoryData = mysqli_query($connectionLocal,$query);
	//si la categoria no existe, necesitamos agregarla
	if(!mysqli_num_rows($categoryData)){
		
		$query = 'SELECT qc.id, qc.name, qc.parent '.
				'FROM '.$PREFIX.'question_categories AS qc '.
				'WHERE qc.id = '.$category_id;
		$categoryResult = mysqli_query($conectionMoodle,$query);		
		$categoryData = mysqli_fetch_assoc($categoryResult);
		if($categoryData['parent'] == 0){
			$query = 'INSERT INTO categorias (nombre, padre, identificador_moodle) VALUES("'.$categoryData['name'].'",0,"'.$CURRENT.'_'.$categoryData['id'].'")';
			mysqli_query($connectionLocal,$query);
			$categoriaID = mysqli_insert_id($connectionLocal);
		} else {
			$padreID = getOrAddCategoria($categoryData['parent'], $connectionLocal, $conectionMoodle);
			
			$query = 'INSERT INTO categorias (nombre, padre, identificador_moodle) VALUES("'.$categoryData['name'].'",'.$padreID.',"'.
					$CURRENT.'_'.$categoryData['id'].'")';
			mysqli_query($connectionLocal,$query);
			$categoriaID = mysqli_insert_id($connectionLocal);
		}
		
	}else{
		$categoryData = mysqli_fetch_assoc($categoryData);
		$categoriaID = $categoryData['id'];
	}
	
	return $categoriaID; 
}					

?>