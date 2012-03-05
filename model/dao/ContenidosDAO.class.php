<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2012-01-18 16:29
 */
interface ContenidosDAO{
	
	/**
	 * Devuelve los contenidos cuyo nombre es similar al parametro $likeString
	 *
	 * @author cgajardo
	 * @param string $likeString
	 */
	public function getLike($likeString);

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Contenidos 
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
 	 * @param contenido primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Contenidos contenido
 	 */
	public function insert($contenido);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Contenidos contenido
 	 */
	public function update($contenido);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByNombre($value);

	public function queryByLinkRepaso($value);

	public function queryByFraseNoLogrado($value);

	public function queryByFraseLogrado($value);

	public function queryByContenidoPadre($value);


	public function deleteByNombre($value);

	public function deleteByLinkRepaso($value);

	public function deleteByFraseNoLogrado($value);

	public function deleteByFraseLogrado($value);

	public function deleteByContenidoPadre($value);
        
        public function queryAllWithPadre();

        public function loadWithPadre($id);
        
        public function getRealContenidos();
}
?>