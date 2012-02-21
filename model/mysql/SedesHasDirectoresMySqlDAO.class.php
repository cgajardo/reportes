<?php
/**
 * Class that operate on table 'sedes_has_directores'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-02-21 18:03
 */
class SedesHasDirectoresMySqlDAO implements SedesHasDirectoresDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return SedesHasDirectoresMySql 
	 */
	public function load($idPersona, $idSede){
		$sql = 'SELECT * FROM sedes_has_directores WHERE id_persona = ?  AND id_sede = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idSede);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM sedes_has_directores';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM sedes_has_directores ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param sedesHasDirectore primary key
 	 */
	public function delete($idPersona, $idSede){
		$sql = 'DELETE FROM sedes_has_directores WHERE id_persona = ?  AND id_sede = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idSede);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SedesHasDirectoresMySql sedesHasDirectore
 	 */
	public function insert($sedesHasDirectore){
		$sql = 'INSERT INTO sedes_has_directores ( id_persona, id_sede) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($sedesHasDirectore->idPersona);

		$sqlQuery->setNumber($sedesHasDirectore->idSede);

		$this->executeInsert($sqlQuery);	
		//$sedesHasDirectore->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param SedesHasDirectoresMySql sedesHasDirectore
 	 */
	public function update($sedesHasDirectore){
		$sql = 'UPDATE sedes_has_directores SET  WHERE id_persona = ?  AND id_sede = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($sedesHasDirectore->idPersona);

		$sqlQuery->setNumber($sedesHasDirectore->idSede);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM sedes_has_directores';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return SedesHasDirectoresMySql 
	 */
	protected function readRow($row){
		$sedesHasDirectore = new SedesHasDirectore();
		
		$sedesHasDirectore->idPersona = $row['id_persona'];
		$sedesHasDirectore->idSede = $row['id_sede'];

		return $sedesHasDirectore;
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
	 * @return SedesHasDirectoresMySql 
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