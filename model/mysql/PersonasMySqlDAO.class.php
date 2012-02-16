<?php
/**
 * Class that operate on table 'personas'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class PersonasMySqlDAO implements PersonasDAO{
	
	/**
	 * Esta función entrega una persona de acuerdo a sus nombres, apellidos
	 * y nombre del grupo al que pertenece. Es una función débil :/
	 * 
	 * @author cgajardo
	 * @param string $nombre_alumno
	 * @param string $nombre_grupo
	 * @return Persona $usuario
	 */
	public function getPersonaByNombreGrupo($nombre_alumno, $nombre_grupo){
		$nombre = explode(",",$nombre_alumno);
		
		$sql = 'SELECT p.* '.
			'FROM galyleo_reportes.personas AS p, galyleo_reportes.grupos_has_estudiantes AS ge, galyleo_reportes.grupos AS g '.
			'WHERE ge.id_persona = p.id AND ge.id_grupo = g.id '.
			'AND p.nombre = ? AND p.apellido = ? AND g.nombre = ? ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString(trim($nombre[0]));
		$sqlQuery->setString(trim($nombre[1]));
		$sqlQuery->setString($nombre_grupo);
		
		return $this->getRow($sqlQuery);
	}
	
	/**
	 * cgajardo: devuelve la lista de personas que pertecenen a un grupo
	 * en rol de alumnos
	 * @param int $grupo_id
	 */
	public function getEstudiantesInGroup($grupo_id){
		$sql = 'SELECT p.* FROM personas AS p, grupos_has_estudiantes AS ge '. 
			 'WHERE ge.id_persona = p.id AND ge.id_grupo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($grupo_id);
		return $this->getList($sqlQuery);
	}

	
	/**
	* cgajardo: obtener al usuario de acuerdo a su id en moodle.
	* @param $plataforma, $idUsuario (comprondan identificador_moodle)
	* @return Persona
	*/
	public function getUserInPlatform($platform, $id){
		$sql = "SELECT * FROM personas WHERE identificador_moodle = ?";
		$sqlQuery = new SqlQuery($sql);
	
		$sqlQuery->set($platform.'_'.$id);
	
		return $this->getRow($sqlQuery);
	}
	
	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return Personas
	 */
	public function load($id){
		$sql = 'SELECT * FROM personas WHERE id = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM personas';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM personas ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param persona primary key
 	 */
	public function delete($id, $nombre, $apellido){
		$sql = 'DELETE FROM personas WHERE id = ?  AND nombre = ?  AND apellido = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		$sqlQuery->setNumber($nombre);
		$sqlQuery->setNumber($apellido);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PersonasMySql persona
 	 */
	public function insert($persona){
		$sql = 'INSERT INTO personas (usuario, correo, rut, identificador_moodle, rol_moodle, id, nombre, apellido) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($persona->usuario);
		$sqlQuery->set($persona->correo);
		$sqlQuery->set($persona->rut);
		$sqlQuery->set($persona->identificadorMoodle);
		$sqlQuery->set($persona->rolMoodle);

		
		$sqlQuery->setNumber($persona->id);

		$sqlQuery->setNumber($persona->nombre);

		$sqlQuery->setNumber($persona->apellido);

		$this->executeInsert($sqlQuery);	
		//$persona->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param PersonasMySql persona
 	 */
	public function update($persona){
		$sql = 'UPDATE personas SET usuario = ?, correo = ?, rut = ?, identificador_moodle = ?, rol_moodle = ? WHERE id = ?  AND nombre = ?  AND apellido = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($persona->usuario);
		$sqlQuery->set($persona->correo);
		$sqlQuery->set($persona->rut);
		$sqlQuery->set($persona->identificadorMoodle);
		$sqlQuery->set($persona->rolMoodle);

		
		$sqlQuery->setNumber($persona->id);

		$sqlQuery->setNumber($persona->nombre);

		$sqlQuery->setNumber($persona->apellido);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM personas';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByUsuario($value){
		$sql = 'SELECT * FROM personas WHERE usuario = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCorreo($value){
		$sql = 'SELECT * FROM personas WHERE correo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRut($value){
		$sql = 'SELECT * FROM personas WHERE rut = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdentificadorMoodle($value){
		$sql = 'SELECT * FROM personas WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByRolMoodle($value){
		$sql = 'SELECT * FROM personas WHERE rol_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByUsuario($value){
		$sql = 'DELETE FROM personas WHERE usuario = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCorreo($value){
		$sql = 'DELETE FROM personas WHERE correo = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRut($value){
		$sql = 'DELETE FROM personas WHERE rut = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdentificadorMoodle($value){
		$sql = 'DELETE FROM personas WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByRolMoodle($value){
		$sql = 'DELETE FROM personas WHERE rol_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return PersonasMySql 
	 */
	protected function readRow($row){
		$persona = new Persona();
		
		$persona->id = $row['id'];
		$persona->nombre = $row['nombre'];
		$persona->apellido = $row['apellido'];
		$persona->usuario = $row['usuario'];
		$persona->correo = $row['correo'];
		$persona->rut = $row['rut'];
		$persona->identificadorMoodle = $row['identificador_moodle'];
		$persona->rolMoodle = $row['rol_moodle'];

		return $persona;
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
	 * @return PersonasMySql 
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

        public function getUserByNombreApellido($nombre, $apellido) {
            $sql = 'SELECT * FROM personas '.
                   ' WHERE nombre = ? AND apellido = ?';
            $sqlQuery = new SqlQuery($sql);
            $sqlQuery->setString($nombre);
            $sqlQuery->setString($apellido);
            return $this->getRow($sqlQuery);

        }

    public function getEstudiantesInQuiz($id_quiz, $id_grupo) {
        
        $sql = 'SELECT p.* FROM intentos i JOIN personas p ON i.id_persona=p.id '.
               'JOIN grupos_has_estudiantes ge ON p.id=ge.id_persona '.
               'WHERE id_quiz=? AND ge.id_grupo=? GROUP BY p.id';
        
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setNumber($id_quiz);
        $sqlQuery->setNumber($id_grupo);
        
        return $this->getList($sqlQuery);
        
    }
}
?>