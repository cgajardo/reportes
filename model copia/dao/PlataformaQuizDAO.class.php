<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface PlataformaQuizDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return PlataformaQuiz 
	 */
	public function load($idPlataforma, $idQuizMoodle);

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
 	 * @param plataformaQuiz primary key
 	 */
	public function delete($idPlataforma, $idQuizMoodle);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PlataformaQuiz plataformaQuiz
 	 */
	public function insert($plataformaQuiz);
	
	/**
 	 * Update record in table
 	 *
 	 * @param PlataformaQuiz plataformaQuiz
 	 */
	public function update($plataformaQuiz);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByIdQuiz($value);


	public function deleteByIdQuiz($value);


}
?>