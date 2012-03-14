<?php

//Object represents table 'grupos'

interface CursosHasContenidosDAO {

	/**
	 * Get Domain object by primry key
	 *
	 * @param primary key
	 * @Return CursosHasContenidos 
	 */
	public function load($idCurso, $fechaInicio, $fechaCierre);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param cursosHasGrupo primary key
 	 */
	public function delete($idCurso, $fechaInicio, $fechaCierre);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param CursosHasGrupos cursosHasGrupo
 	 */
	public function insert($cursosHasContenidos);
	
	/**
 	 * Update record in table
 	 *
 	 * @param CursosHasGrupos cursosHasGrupo
 	 */
	public function update($cursosHasContenidos, $fechaInicioVieja, $fechaCierreVieja);	

	/**
	 * Delete all rows
	 */
	public function clean();

        public function getByCurso($id_curso);
        
        public function getByCursoWithContenidos($id_curso);
        public function getCerradosByCurso($id_curso);
        
        public function getActuales($id_curso);

}
?>