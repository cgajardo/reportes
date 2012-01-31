<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface GruposHasEstudiantesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return GruposHasEstudiantes 
	 */
	public function load($idPersona, $idGrupo);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param gruposHasEstudiante primary key
 	 */
	public function delete($idPersona, $idGrupo);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param GruposHasEstudiantes gruposHasEstudiante
 	 */
	public function insert($gruposHasEstudiante);
	
	/**
 	 * Update record in table
 	 *
 	 * @param GruposHasEstudiantes gruposHasEstudiante
 	 */
	public function update($gruposHasEstudiante);	

	/**
	 * Delete all rows
	 */
	public function clean();



}
?>