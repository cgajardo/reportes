<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface SedesHasCursosDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return SedesHasCursos 
	 */
	public function load($idSede, $idCurso);

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
 	 * @param sedesHasCurso primary key
 	 */
	public function delete($idSede, $idCurso);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SedesHasCursos sedesHasCurso
 	 */
	public function insert($sedesHasCurso);
	
	/**
 	 * Update record in table
 	 *
 	 * @param SedesHasCursos sedesHasCurso
 	 */
	public function update($sedesHasCurso);	

	/**
	 * Delete all rows
	 */
	public function clean();



}
?>