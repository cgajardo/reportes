<?php
/**
 * Class that operate on table 'sedes'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class SedesMySqlDAO implements SedesDAO{

	/**
	 * Esta función entrega la asociada a un director
	 * para un nombre de sede dado.
	 * 
	 * @author cgajardo
	 * @param int $id_director
	 * @param string $nombre_sede
	 */
	public function getByDirectorAndNombre($id_director, $nombre_sede){
		$sql = 'SELECT s.* '.
				'FROM sedes as s, sedes_has_directores as sd '.
				'WHERE s.id = sd.id_sede AND sd.id_persona = ? AND s.nombre = ? ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id_director);
		$sqlQuery->setString($nombre_sede);
		
		return $this->getRow($sqlQuery);
	}
	
	/**
	 * Esta función devuelve la lista de sedes en las cuales una persona es director
	 * Si se trata de un director de institucion (rector) entonces podrá revisar todas las sedes
	 * 
	 * @author cgajardo
	 * @param int $director_id
	 */
	public function getSedesByDirector($director_id){
		//si es director en institucion devolvemos todas las sedes de la institucion
		if(DAOFactory::getPersonasDAO()->checkRolDirector($director_id)){
			$sql = 'SELECT * '. 
					'FROM sedes '.
					'WHERE id_institucion IN ('.
    					'SELECT id_institucion '.
						'FROM instituciones_has_directores '. 
						'WHERE id_persona = ?)';
		}else{
			///si es director solo en una sede..
			$sql = 'SELECT s.* '.
					'FROM sedes as s, sedes_has_directores as sd '.
					'WHERE s.id = sd.id_sede AND sd.id_persona = ? ';
		}
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($director_id);
		
		return $this->getList($sqlQuery);
	}
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return SedesMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM sedes WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM sedes';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM sedes ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param sede primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM sedes WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SedesMySql sede
 	 */
	public function insert($sede){
		$sql = 'INSERT INTO sedes (nombre, pais, region, ciudad, id_institucion) VALUES (?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setString($sede->nombre);
		$sqlQuery->setString($sede->pais);
		$sqlQuery->setString($sede->region);
		$sqlQuery->setString($sede->ciudad);
		$sqlQuery->setNumber($sede->idInstitucion);
                
                return $this->executeInsert($sqlQuery);	
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param SedesMySql sede
 	 */
	public function update($sede){
		$sql = 'UPDATE sedes SET nombre = ?, pais = ?, region = ?, ciudad = ?, id_institucion = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($sede->nombre);
		$sqlQuery->set($sede->pais);
		$sqlQuery->set($sede->region);
		$sqlQuery->set($sede->ciudad);
		$sqlQuery->setNumber($sede->idInstitucion);

		$sqlQuery->setNumber($sede->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM sedes';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM sedes WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPais($value){
		$sql = 'SELECT * FROM sedes WHERE pais = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRegion($value){
		$sql = 'SELECT * FROM sedes WHERE region = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCiudad($value){
		$sql = 'SELECT * FROM sedes WHERE ciudad = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdInstitucion($value){
		$sql = 'SELECT * FROM sedes WHERE id_institucion = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM sedes WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPais($value){
		$sql = 'DELETE FROM sedes WHERE pais = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRegion($value){
		$sql = 'DELETE FROM sedes WHERE region = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCiudad($value){
		$sql = 'DELETE FROM sedes WHERE ciudad = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdInstitucion($value){
		$sql = 'DELETE FROM sedes WHERE id_institucion = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return SedesMySql 
	 */
	protected function readRow($row){
		$sede = new Sede();
		
		$sede->id = $row['id'];
		$sede->nombre = $row['nombre'];
		$sede->pais = $row['pais'];
		$sede->region = $row['region'];
		$sede->ciudad = $row['ciudad'];
		$sede->idInstitucion = $row['id_institucion'];

		return $sede;
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
	 * @return SedesMySql 
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

    public function getSedesByInstitucion($id_institucion) {
        
        $sql ='SELECT * FROM sedes WHERE id_institucion=?';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setNumber($id_institucion);
        
        return $this->getList($sqlQuery);
        
        
    }
}
?>
