<?php
/**
 * Class that operate on table 'intentos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class IntentosMySqlDAO implements IntentosDAO{
	
	
	
	/**
	* cgajardo: Devuelve una lista de los quizes que ha respondido un usuario
	* @param $idUsuarioGalyleo en identificador del usuario en la plataforma de reportes
	* @return $quizes_id devuelve una lista de intentos
	*/
	public function getIntentosByUsuario($idUsuarioGalyleo){
		$sql = 'SELECT * FROM intentos WHERE id_persona = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idUsuarioGalyleo);
		
		return $this->getList($sqlQuery);
	}

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return IntentosMySql 
	 */
	public function load($id, $idPersona, $idQuiz, $idPregunta){
		$sql = 'SELECT * FROM intentos WHERE id = ?  AND id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM intentos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM intentos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param intento primary key
 	 */
	public function delete($id, $idPersona, $idQuiz, $idPregunta){
		$sql = 'DELETE FROM intentos WHERE id = ?  AND id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param IntentosMySql intento
 	 */
	public function insert($intento){
		$sql = 'INSERT INTO intentos (puntaje_pregunta, fecha, numero_intento, id, id_persona, id_quiz, id_pregunta) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($intento->puntajePregunta);
		$sqlQuery->set($intento->fecha);
		$sqlQuery->setNumber($intento->numeroIntento);

		
		$sqlQuery->setNumber($intento->id);

		$sqlQuery->setNumber($intento->idPersona);

		$sqlQuery->setNumber($intento->idQuiz);

		$sqlQuery->setNumber($intento->idPregunta);

		$this->executeInsert($sqlQuery);	
		//$intento->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param IntentosMySql intento
 	 */
	public function update($intento){
		$sql = 'UPDATE intentos SET puntaje_pregunta = ?, fecha = ?, numero_intento = ? WHERE id = ?  AND id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($intento->puntajePregunta);
		$sqlQuery->set($intento->fecha);
		$sqlQuery->setNumber($intento->numeroIntento);

		
		$sqlQuery->setNumber($intento->id);

		$sqlQuery->setNumber($intento->idPersona);

		$sqlQuery->setNumber($intento->idQuiz);

		$sqlQuery->setNumber($intento->idPregunta);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM intentos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByPuntajePregunta($value){
		$sql = 'SELECT * FROM intentos WHERE puntaje_pregunta = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFecha($value){
		$sql = 'SELECT * FROM intentos WHERE fecha = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNumeroIntento($value){
		$sql = 'SELECT * FROM intentos WHERE numero_intento = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByPuntajePregunta($value){
		$sql = 'DELETE FROM intentos WHERE puntaje_pregunta = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFecha($value){
		$sql = 'DELETE FROM intentos WHERE fecha = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNumeroIntento($value){
		$sql = 'DELETE FROM intentos WHERE numero_intento = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return IntentosMySql 
	 */
	protected function readRow($row){
		$intento = new Intento();
		
		$intento->id = $row['id'];
		$intento->idPersona = $row['id_persona'];
		$intento->idQuiz = $row['id_quiz'];
		$intento->idPregunta = $row['id_pregunta'];
		$intento->puntajePregunta = $row['puntaje_pregunta'];
		$intento->fecha = $row['fecha'];
		$intento->numeroIntento = $row['numero_intento'];

		return $intento;
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
	 * @return IntentosMySql 
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
	
	/** 
	* cgajardo:
	* obtener todos los intentos de un usuario para un control y una pregunta dada
	*/
	public function getIntentosByUsuarioQuizPregunta($idPersona, $idQuiz, $idPregunta){
		$sql = 'SELECT * FROM intentos WHERE id_persona = ?  AND id_quiz = ?  AND id_pregunta = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idQuiz);
		$sqlQuery->setNumber($idPregunta);

		return $this->getRow($sqlQuery);

		
	}
}
?>