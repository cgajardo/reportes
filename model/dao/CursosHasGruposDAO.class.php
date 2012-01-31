<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface CursosHasGruposDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return CursosHasGrupos 
	 */
	public function load($idGrupo, $idCurso);

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
 	 * @param cursosHasGrupo primary key
 	 */
	public function delete($idGrupo, $idCurso);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CursosHasGrupos cursosHasGrupo
 	 */
	public function insert($cursosHasGrupo);
	
	/**
 	 * Update record in table
 	 *
 	 * @param CursosHasGrupos cursosHasGrupo
 	 */
	public function update($cursosHasGrupo);	

	/**
	 * Delete all rows
	 */
	public function clean();



}
?>