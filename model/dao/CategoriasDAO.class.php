<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-24 15:19
 */
interface CategoriasDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Categorias 
	 */
	public function load($id);

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
 	 * @param categoria primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Categorias categoria
 	 */
	public function insert($categoria);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Categorias categoria
 	 */
	public function update($categoria);
        
        public function updateContenido($id_categoria,$id_contenido);

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombre($value);

	public function queryByPadre($value);

	public function queryByIdentificadorMoodle($value);


	public function deleteByNombre($value);

	public function deleteByPadre($value);

	public function deleteByIdentificadorMoodle($value);
        
        public function getCategoriasByQuiz($id_quiz);
        
        public function getCategoriasByQuizWithContenido($id_quiz);
        


}
?>