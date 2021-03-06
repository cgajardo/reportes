<?php
/**
 * Class that operate on table 'cursos'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
class CursosMySqlDAO implements CursosDAO{
	
	
	/**
	 * Esta funcion sólo debería usarse en las llamada de ajax, 
	 * fuera de ahí no tien sentido y podría ser inseguro usarlas
	 * 
	 * Devulve un curso de acuerdo al nombre del grupo y el curso
	 * 
	 * @author cgajardo
	 * @param string $nombre_grupo
	 * @param string $nombre_grupo
	 */
	public function getCursoByNombreGrupoCurso($nombre_grupo, $nombre_curso){
		
		
		$sql = 'SELECT c.* '.
			'FROM cursos_has_grupos AS cg, '.
                        'cursos as c , grupos as g '.
			'WHERE g.nombre = ? '.
			'AND c.nombre = ? '.
			'AND c.id=cg.id_curso AND g.id = cg.id_grupo ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($nombre_grupo);
		$sqlQuery->setString($nombre_curso);
		
		return $this->getRow($sqlQuery);
	}
	
	/**
	 * Esta funcion sólo debería usarse en las llamada de ajax, 
	 * fuera de ahí no tien sentido y podría ser inseguro usarlas
	 * 
	 * Devuelve un curso para un nombre y un usuario dado
	 * 
	 * @author cgajardo
	 * @param int $usuario_id
	 * @param string $nombre_curso
	 */
	public function getCursosByUsuarioAndNombre($usuario_id, $nombre_curso){
		$sql = 'SELECT c.* '.
				'FROM cursos as c '.
				'WHERE c.id IN ('.
					'SELECT id_curso '.
					'FROM cursos_has_grupos '.
					'WHERE id_grupo IN ('.
						'SELECT id_grupo '.
						'FROM grupos_has_estudiantes '.
						'WHERE id_persona = ?)'.
					') '.
				'AND c.nombre = ? ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($usuario_id);
		$sqlQuery->setString($nombre_curso);
		
		return $this->getRow($sqlQuery);
	}
	
	/**
	 * Devuelve un curso en una Sede de nombre dado.
	 * 
	 * @author cgajardo
	 * @param int $sede_id
	 * @param string $nombre_curso
	 */
	public function getCursoBySedeAndNombre($sede_id, $nombre_curso){
		$sql = 'SELECT c.* '. 
			'FROM cursos AS c, sedes_has_cursos AS sc '. 
			'WHERE c.id = sc.id_curso '. 
			'AND sc.id_sede = ? '. 
			'AND c.nombre = ? ';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($sede_id);
		$sqlQuery->set($nombre_curso);
		
		return $this->getRow($sqlQuery);
	}
	
	/**
	 * Devuelve una lista de cursos asociados a una Sede
	 * 
	 * @authos: cgajardo
	 * @param int $sede_id
	 */
	public function getCursosInSede($sede_id){
		$sql = 'SELECT c.* FROM cursos c 
                        JOIN cursos_has_grupos cg ON c.id=cg.id_curso 
                        JOIN grupos g ON cg.id_grupo=g.id 
                        WHERE g.id_sede = ? 
                        GROUP BY c.id';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($sede_id);
		
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Entrega un listado en los cuales el usuario está inscrito
	 * 
	 * @author: cgajardo
	 * @param int $usuario_id
	 */
	public function getCursosByUsuario($usuario_id){
		$sql = 'SELECT c.* 
                    FROM cursos c 
                    JOIN cursos_has_grupos cg ON c.id=cg.id_curso 
                    JOIN grupos_has_estudiantes ge ON cg.id_grupo = ge.id_grupo 
                    WHERE ge.id_persona = ?
                    GROUP BY c.id';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($usuario_id); 
		return $this->getList($sqlQuery);
		
	}
        
        public function getCursosByProfesor($usuario_id){
		$sql = 'SELECT c.* FROM cursos c 
                        JOIN cursos_has_grupos cg ON c.id=cg.id_curso 
                        JOIN grupos_has_profesores gp ON cg.id_grupo=gp.id_grupo 
                        WHERE gp.id_persona = ?';
		
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($usuario_id);
		
		return $this->getList($sqlQuery);
		
	}
	
	
	/**
	 * 
	 * @param int $grupo_id
	 */
	public function getCursoByGrupoId($grupo_id){
		$sql = "SELECT c.* FROM cursos AS c, cursos_has_grupos AS cg WHERE cg.id_curso = c.id AND cg.id_grupo = ?";
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($grupo_id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return CursosMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM cursos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM cursos';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM cursos ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param curso primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM cursos WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CursosMySql curso
 	 */
	public function insert($curso){
		$sql = 'INSERT INTO cursos (nombre, nombre_corto, identificador_moodle) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($curso->nombre);
		$sqlQuery->set($curso->nombreCorto);
		$sqlQuery->set($curso->identificadorMoodle);

		$id = $this->executeInsert($sqlQuery);	
		$curso->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param CursosMySql curso
 	 */
	public function update($curso){
		$sql = 'UPDATE cursos SET nombre = ?, nombre_corto = ?, identificador_moodle = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($curso->nombre);
		$sqlQuery->set($curso->nombreCorto);
		$sqlQuery->set($curso->identificadorMoodle);

		$sqlQuery->setNumber($curso->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM cursos';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByNombre($value){
		$sql = 'SELECT * FROM cursos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByNombreCorto($value){
		$sql = 'SELECT * FROM cursos WHERE nombre_corto = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIdentificadorMoodle($value){
		$sql = 'SELECT * FROM cursos WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setString($value);
		return $this->getRow($sqlQuery);
	}


	public function deleteByNombre($value){
		$sql = 'DELETE FROM cursos WHERE nombre = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByNombreCorto($value){
		$sql = 'DELETE FROM cursos WHERE nombre_corto = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIdentificadorMoodle($value){
		$sql = 'DELETE FROM cursos WHERE identificador_moodle = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return CursosMySql 
	 */
	protected function readRow($row){
		$curso = new Curso();
		
		$curso->id = $row['id'];
		$curso->nombre = $row['nombre'];
		$curso->nombreCorto = $row['nombre_corto'];
		$curso->identificadorMoodle = $row['identificador_moodle'];
                $curso->nivelacion = $row['nivelacion'];

		return $curso;
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
	 * @return CursosMySql 
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
        
        public function getNivelacionCierre($id_curso){
                $sql = 'SELECT * FROM cierre_nivelacion 
                    WHERE id_curso = ?';
                $sqlQuery = new SqlQuery($sql);
                $sqlQuery->setNumber($id_curso);
                
                return $this->getRowCierre($sqlQuery);
        }
        
        protected function getRowCierre($sqlQuery){
                $tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		$cierre = new CierreNivelacion();
		$cierre->idCurso = $tab[0]['id_curso'];               
		$cierre->fechaCierre = $tab[0]['fecha_cierre'];               

		return $cierre;
	}
        
}       
?>
