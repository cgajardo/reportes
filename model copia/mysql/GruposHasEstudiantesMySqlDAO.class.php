<?php
/**
 * Class that operate on table 'grupos_has_estudiantes'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class GruposHasEstudiantesMySqlDAO implements GruposHasEstudiantesDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return GruposHasEstudiantesMySql 
	 */
	public function load($idPersona, $idGrupo){
		$sql = 'SELECT * FROM grupos_has_estudiantes WHERE id_persona = ?  AND id_grupo = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idGrupo);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM grupos_has_estudiantes';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM grupos_has_estudiantes ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param gruposHasEstudiante primary key
 	 */
	public function delete($idPersona, $idGrupo){
		$sql = 'DELETE FROM grupos_has_estudiantes WHERE id_persona = ?  AND id_grupo = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($idPersona);
		$sqlQuery->setNumber($idGrupo);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param GruposHasEstudiantesMySql gruposHasEstudiante
 	 */
	public function insert($gruposHasEstudiante){
		$sql = 'INSERT INTO grupos_has_estudiantes ( id_persona, id_grupo) VALUES ( ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($gruposHasEstudiante->idPersona);

		$sqlQuery->setNumber($gruposHasEstudiante->idGrupo);

		$this->executeInsert($sqlQuery);	
		//$gruposHasEstudiante->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param GruposHasEstudiantesMySql gruposHasEstudiante
 	 */
	public function update($gruposHasEstudiante){
		$sql = 'UPDATE grupos_has_estudiantes SET  WHERE id_persona = ?  AND id_grupo = ? ';
		$sqlQuery = new SqlQuery($sql);
		

		
		$sqlQuery->setNumber($gruposHasEstudiante->idPersona);

		$sqlQuery->setNumber($gruposHasEstudiante->idGrupo);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM grupos_has_estudiantes';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}



	
	/**
	 * Read row
	 *
	 * @return GruposHasEstudiantesMySql 
	 */
	protected function readRow($row){
		$gruposHasEstudiante = new GruposHasEstudiante();
		
		$gruposHasEstudiante->idPersona = $row['id_persona'];
		$gruposHasEstudiante->idGrupo = $row['id_grupo'];

		return $gruposHasEstudiante;
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
	 * @return GruposHasEstudiantesMySql 
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