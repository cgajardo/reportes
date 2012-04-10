<?php
/**
 * Class that operate on table 'quizes_has_Categorias'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class QuizesHasCategoriasMySqlDAO implements QuizesHasCategoriasDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return QuizesHasCategoriasMySql 
	 */
	public function load($idQuiz, $idCategoria){
		$sql = 'SELECT * FROM quizes_has_Categorias WHERE id_quiz = ?  AND id_Categoria = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idCategoria);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM quizes_has_Categorias';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM quizes_has_Categorias ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param quizesHasCategoria primary key
 	 */
	public function delete($idQuiz, $idCategoria){
		$sql = 'DELETE FROM quizes_has_Categorias WHERE id_quiz = ?  AND id_Categoria = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idCategoria);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param QuizesHasCategoriasMySql quizesHasCategoria
 	 */
	public function insert($quizesHasCategoria){
		$sql = 'INSERT INTO quizes_has_Categorias ( id_quiz, id_Categoria) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
				
		$sqlQuery->setNumber($quizesHasCategoria->idQuiz);

		$sqlQuery->setNumber($quizesHasCategoria->idCategoria);

		$this->executeInsert($sqlQuery);	
		//$quizesHasCategoria->id = $id;
		//return $id;
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM quizes_has_Categorias';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
	 * Read row
	 *
	 * @return QuizesHasCategoriasMySql 
	 */
	protected function readRow($row){
		$quizesHasCategoria = new QuizesHasCategoria();
		
		$quizesHasCategoria->idQuiz = $row['id_quiz'];
		$quizesHasCategoria->idCategoria = $row['id_Categoria'];

		return $quizesHasCategoria;
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
	 * @return QuizesHasCategoriasMySql 
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