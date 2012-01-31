<?php
/**
 * Class that operate on table 'estado'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class EstadoMySqlDAO implements EstadoDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return EstadoMySql 
	 */
	public function load($idPlataforma, $variable){
		$sql = 'SELECT * FROM estado WHERE id_plataforma = ?  AND variable = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPlataforma);
		$sqlQuery->setNumber($variable);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM estado';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM estado ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param estado primary key
 	 */
	public function delete($idPlataforma, $variable){
		$sql = 'DELETE FROM estado WHERE id_plataforma = ?  AND variable = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPlataforma);
		$sqlQuery->setNumber($variable);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param EstadoMySql estado
 	 */
	public function insert($estado){
		$sql = 'INSERT INTO estado (valor, id_plataforma, variable) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($estado->valor);

		
		$sqlQuery->setNumber($estado->idPlataforma);

		$sqlQuery->setNumber($estado->variable);

		$this->executeInsert($sqlQuery);	
		//$estado->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param EstadoMySql estado
 	 */
	public function update($estado){
		$sql = 'UPDATE estado SET valor = ? WHERE id_plataforma = ?  AND variable = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($estado->valor);

		
		$sqlQuery->setNumber($estado->idPlataforma);

		$sqlQuery->setNumber($estado->variable);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM estado';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByValor($value){
		$sql = 'SELECT * FROM estado WHERE valor = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByValor($value){
		$sql = 'DELETE FROM estado WHERE valor = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return EstadoMySql 
	 */
	protected function readRow($row){
		$estado = new Estado();
		
		$estado->idPlataforma = $row['id_plataforma'];
		$estado->variable = $row['variable'];
		$estado->valor = $row['valor'];

		return $estado;
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
	 * @return EstadoMySql 
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