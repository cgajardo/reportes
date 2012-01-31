<?php
/**
 * Class that operate on table 'sedes_has_directoressede'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class SedesHasDirectoressedeMySqlDAO implements SedesHasDirectoressedeDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return SedesHasDirectoressedeMySql 
	 */
	public function load($idPersona, $idSede){
		$sql = 'SELECT * FROM sedes_has_directoressede WHERE id_persona = ?  AND id_sede = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idSede);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM sedes_has_directoressede';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM sedes_has_directoressede ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param sedesHasDirectoressede primary key
 	 */
	public function delete($idPersona, $idSede){
		$sql = 'DELETE FROM sedes_has_directoressede WHERE id_persona = ?  AND id_sede = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idSede);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SedesHasDirectoressedeMySql sedesHasDirectoressede
 	 */
	public function insert($sedesHasDirectoressede){
		$sql = 'INSERT INTO sedes_has_directoressede ( id_persona, id_sede) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($sedesHasDirectoressede->idPersona);

		$sqlQuery->setNumber($sedesHasDirectoressede->idSede);

		$this->executeInsert($sqlQuery);	
		//$sedesHasDirectoressede->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param SedesHasDirectoressedeMySql sedesHasDirectoressede
 	 */
	public function update($sedesHasDirectoressede){
		$sql = 'UPDATE sedes_has_directoressede SET  WHERE id_persona = ?  AND id_sede = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($sedesHasDirectoressede->idPersona);

		$sqlQuery->setNumber($sedesHasDirectoressede->idSede);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM sedes_has_directoressede';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return SedesHasDirectoressedeMySql 
	 */
	protected function readRow($row){
		$sedesHasDirectoressede = new SedesHasDirectoressede();
		
		$sedesHasDirectoressede->idPersona = $row['id_persona'];
		$sedesHasDirectoressede->idSede = $row['id_sede'];

		return $sedesHasDirectoressede;
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
	 * @return SedesHasDirectoressedeMySql 
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