<?php
/**
 * Class that operate on table 'instituciones'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class InstitucionesMySqlDAO implements InstitucionesDAO{
	
	
	
	/**
	 * Esta función devuelve la institacion asociada a una plataforma
	 * dado el nombre de la plataforma
	 * 
	 * @author cgajardo 
	 * @param string $platforma
	 */
	public function getInstitucionByNombrePlataforma($platforma){
		$sql = 'SELECT i.* '.
			'FROM instituciones as i '.
			'WHERE i.id IN ( '.
  				'SELECT ip.id_institucion '.
  				'FROM instituciones_has_plataformas AS ip, plataformas AS p '.
  				'WHERE p.nombre = ? )';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($platforma);
		
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return InstitucionesMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM instituciones WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM instituciones';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM instituciones ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param institucione primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM instituciones WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param InstitucionesMySql institucione
 	 */
	public function insert($institucione){
		$sql = 'INSERT INTO instituciones (nombre, nombre_corto) VALUES (?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($institucione->nombre);
		$sqlQuery->set($institucione->nombreCorto);

		$id = $this->executeInsert($sqlQuery);	
		$institucione->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param InstitucionesMySql institucione
 	 */
	public function update($institucione){
		$sql = 'UPDATE instituciones SET nombre = ?, nombre_corto = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($institucione->nombre);
		$sqlQuery->set($institucione->nombreCorto);

		$sqlQuery->setNumber($institucione->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM instituciones';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM instituciones WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNombreCorto($value){
		$sql = 'SELECT * FROM instituciones WHERE nombre_corto = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM instituciones WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNombreCorto($value){
		$sql = 'DELETE FROM instituciones WHERE nombre_corto = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return InstitucionesMySql 
	 */
	protected function readRow($row){
		$institucione = new Institucione();
		
		$institucione->id = $row['id'];
		$institucione->nombre = $row['nombre'];
		$institucione->nombreCorto = $row['nombre_corto'];

		return $institucione;
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
	 * @return InstitucionesMySql 
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