<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-02-22 10:58
 */
interface SemestresDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Semestres 
	 */
	public function load($id);

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
 	 * @param semestre primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Semestres semestre
 	 */
	public function insert($semestre);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Semestres semestre
 	 */
	public function update($semestre);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByFechaInicio($value);

	public function queryByFechaTermino($value);

	public function queryByTotalSemanas($value);

	public function queryByIdSede($value);


	public function deleteByFechaInicio($value);

	public function deleteByFechaTermino($value);

	public function deleteByTotalSemanas($value);

	public function deleteByIdSede($value);


}
?>