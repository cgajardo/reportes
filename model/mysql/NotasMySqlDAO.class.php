<?php
/**
 * Class that operate on table 'notas'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class NotasMySqlDAO implements NotasDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return NotasMySql 
	 */
	public function load($idPersona, $idQuiz, $idPregunta){
		$sql = 'SELECT * FROM notas WHERE id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM notas';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM notas ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param nota primary key
 	 */
	public function delete($idPersona, $idQuiz, $idPregunta){
		$sql = 'DELETE FROM notas WHERE id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param NotasMySql nota
 	 */
	public function insert($nota){
		$sql = 'INSERT INTO notas (puntaje_pregunta, id_persona, id_quiz, id_pregunta) VALUES (?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($nota->puntajePregunta);

		
		$sqlQuery->setNumber($nota->idPersona);

		$sqlQuery->setNumber($nota->idQuiz);

		$sqlQuery->setNumber($nota->idPregunta);

		$this->executeInsert($sqlQuery);	
		//$nota->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param NotasMySql nota
 	 */
	public function update($nota){
		$sql = 'UPDATE notas SET puntaje_pregunta = ? WHERE id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($nota->puntajePregunta);

		
		$sqlQuery->setNumber($nota->idPersona);

		$sqlQuery->setNumber($nota->idQuiz);

		$sqlQuery->setNumber($nota->idPregunta);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM notas';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByPuntajePregunta($value){
		$sql = 'SELECT * FROM notas WHERE puntaje_pregunta = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByPuntajePregunta($value){
		$sql = 'DELETE FROM notas WHERE puntaje_pregunta = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return NotasMySql 
	 */
	protected function readRow($row){
		$nota = new Nota();
		
		$nota->idPersona = $row['id_persona'];
		$nota->idQuiz = $row['id_quiz'];
		$nota->idPregunta = $row['id_pregunta'];
		$nota->puntajePregunta = $row['puntaje_pregunta'];

		return $nota;
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
	 * @return NotasMySql 
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
        
        /*
         * jtoro:Obtener la nota maxima en un quiz
         */
        public function getMaxNotaInQuiz($quiz){
            
                $sql='SELECT nota_maxima FROM quizes WHERE id= ? ';
                $sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($quiz);
		return $this->getList($sqlQuery);
        }
}       
?>