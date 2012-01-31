<?php
/**
 * Class that operate on table 'instituciones_has_directores'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class InstitucionesHasDirectoresMySqlDAO implements InstitucionesHasDirectoresDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return InstitucionesHasDirectoresMySql 
	 */
	public function load($idInstituacion, $idPersona){
		$sql = 'SELECT * FROM instituciones_has_directores WHERE id_instituacion = ?  AND id_persona = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idInstituacion);
		$sqlQuery->setNumber($idPersona);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM instituciones_has_directores';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM instituciones_has_directores ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param institucionesHasDirectore primary key
 	 */
	public function delete($idInstituacion, $idPersona){
		$sql = 'DELETE FROM instituciones_has_directores WHERE id_instituacion = ?  AND id_persona = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idInstituacion);
		$sqlQuery->setNumber($idPersona);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InstitucionesHasDirectoresMySql institucionesHasDirectore
 	 */
	public function insert($institucionesHasDirectore){
		$sql = 'INSERT INTO instituciones_has_directores ( id_instituacion, id_persona) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($institucionesHasDirectore->idInstituacion);

		$sqlQuery->setNumber($institucionesHasDirectore->idPersona);

		$this->executeInsert($sqlQuery);	
		//$institucionesHasDirectore->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param InstitucionesHasDirectoresMySql institucionesHasDirectore
 	 */
	public function update($institucionesHasDirectore){
		$sql = 'UPDATE instituciones_has_directores SET  WHERE id_instituacion = ?  AND id_persona = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($institucionesHasDirectore->idInstituacion);

		$sqlQuery->setNumber($institucionesHasDirectore->idPersona);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM instituciones_has_directores';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return InstitucionesHasDirectoresMySql 
	 */
	protected function readRow($row){
		$institucionesHasDirectore = new InstitucionesHasDirectore();
		
		$institucionesHasDirectore->idInstituacion = $row['id_instituacion'];
		$institucionesHasDirectore->idPersona = $row['id_persona'];

		return $institucionesHasDirectore;
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
	 * @return InstitucionesHasDirectoresMySql 
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