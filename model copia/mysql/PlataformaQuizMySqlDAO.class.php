<?php
/**
 * Class that operate on table 'plataforma_quiz'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class PlataformaQuizMySqlDAO implements PlataformaQuizDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return PlataformaQuizMySql 
	 */
	public function load($idPlataforma, $idQuizMoodle){
		$sql = 'SELECT * FROM plataforma_quiz WHERE id_plataforma = ?  AND id_quiz_moodle = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPlataforma);
		$sqlQuery->setNumber($idQuizMoodle);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM plataforma_quiz';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM plataforma_quiz ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param plataformaQuiz primary key
 	 */
	public function delete($idPlataforma, $idQuizMoodle){
		$sql = 'DELETE FROM plataforma_quiz WHERE id_plataforma = ?  AND id_quiz_moodle = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPlataforma);
		$sqlQuery->setNumber($idQuizMoodle);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PlataformaQuizMySql plataformaQuiz
 	 */
	public function insert($plataformaQuiz){
		$sql = 'INSERT INTO plataforma_quiz (id_quiz, id_plataforma, id_quiz_moodle) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($plataformaQuiz->idQuiz);

		
		$sqlQuery->setNumber($plataformaQuiz->idPlataforma);

		$sqlQuery->setNumber($plataformaQuiz->idQuizMoodle);

		$this->executeInsert($sqlQuery);	
		//$plataformaQuiz->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param PlataformaQuizMySql plataformaQuiz
 	 */
	public function update($plataformaQuiz){
		$sql = 'UPDATE plataforma_quiz SET id_quiz = ? WHERE id_plataforma = ?  AND id_quiz_moodle = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($plataformaQuiz->idQuiz);

		
		$sqlQuery->setNumber($plataformaQuiz->idPlataforma);

		$sqlQuery->setNumber($plataformaQuiz->idQuizMoodle);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM plataforma_quiz';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByIdQuiz($value){
		$sql = 'SELECT * FROM plataforma_quiz WHERE id_quiz = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByIdQuiz($value){
		$sql = 'DELETE FROM plataforma_quiz WHERE id_quiz = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return PlataformaQuizMySql 
	 */
	protected function readRow($row){
		$plataformaQuiz = new PlataformaQuiz();
		
		$plataformaQuiz->idQuiz = $row['id_quiz'];
		$plataformaQuiz->idPlataforma = $row['id_plataforma'];
		$plataformaQuiz->idQuizMoodle = $row['id_quiz_moodle'];

		return $plataformaQuiz;
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
	 * @return PlataformaQuizMySql 
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