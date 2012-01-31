<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface QuizesHasPreguntasDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return QuizesHasPreguntas 
	 */
	public function load($idQuiz, $idPregunta);

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
 	 * @param quizesHasPregunta primary key
 	 */
	public function delete($idQuiz, $idPregunta);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param QuizesHasPreguntas quizesHasPregunta
 	 */
	public function insert($quizesHasPregunta);
	
	/**
 	 * Update record in table
 	 *
 	 * @param QuizesHasPreguntas quizesHasPregunta
 	 */
	public function update($quizesHasPregunta);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByPuntajeMaximo($value);


	public function deleteByPuntajeMaximo($value);


}
?>