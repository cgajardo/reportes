<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface NotasDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Notas 
	 */
	public function load($idPersona, $idQuiz, $idPregunta);

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
 	 * @param nota primary key
 	 */
	public function delete($idPersona, $idQuiz, $idPregunta);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Notas nota
 	 */
	public function insert($nota);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Notas nota
 	 */
	public function update($nota);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByPuntajePregunta($value);


	public function deleteByPuntajePregunta($value);


}
?>