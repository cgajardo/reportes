<?php
/**
 * Class that operate on table 'quizes_has_preguntas'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class QuizesHasPreguntasMySqlDAO implements QuizesHasPreguntasDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return QuizesHasPreguntasMySql 
	 */
	public function load($idQuiz, $idPregunta){
		$sql = 'SELECT * FROM quizes_has_preguntas WHERE id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM quizes_has_preguntas';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM quizes_has_preguntas ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param quizesHasPregunta primary key
 	 */
	public function delete($idQuiz, $idPregunta){
		$sql = 'DELETE FROM quizes_has_preguntas WHERE id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param QuizesHasPreguntasMySql quizesHasPregunta
 	 */
	public function insert($quizesHasPregunta){
		$sql = 'INSERT INTO quizes_has_preguntas (puntaje_maximo, id_quiz, id_pregunta) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($quizesHasPregunta->puntajeMaximo);

		
		$sqlQuery->setNumber($quizesHasPregunta->idQuiz);

		$sqlQuery->setNumber($quizesHasPregunta->idPregunta);

		$this->executeInsert($sqlQuery);	
		//$quizesHasPregunta->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param QuizesHasPreguntasMySql quizesHasPregunta
 	 */
	public function update($quizesHasPregunta){
		$sql = 'UPDATE quizes_has_preguntas SET puntaje_maximo = ? WHERE id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($quizesHasPregunta->puntajeMaximo);

		
		$sqlQuery->setNumber($quizesHasPregunta->idQuiz);

		$sqlQuery->setNumber($quizesHasPregunta->idPregunta);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM quizes_has_preguntas';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByPuntajeMaximo($value){
		$sql = 'SELECT * FROM quizes_has_preguntas WHERE puntaje_maximo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByPuntajeMaximo($value){
		$sql = 'DELETE FROM quizes_has_preguntas WHERE puntaje_maximo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return QuizesHasPreguntasMySql 
	 */
	protected function readRow($row){
		$quizesHasPregunta = new QuizesHasPregunta();
		
		$quizesHasPregunta->idQuiz = $row['id_quiz'];
		$quizesHasPregunta->idPregunta = $row['id_pregunta'];
		$quizesHasPregunta->puntajeMaximo = $row['puntaje_maximo'];

		return $quizesHasPregunta;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return QuizesHasPreguntasMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>