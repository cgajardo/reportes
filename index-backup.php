<?php
//include all DAO files
include_once("include_dao.php");
print("Inicio Pruebas</br><hr /></br>");

//Ejemplo de cómo obtener todos los cursos
$curso = DAOFactory::getCursosDAO()->queryAll();
print_r($curso);
echo '</br></br>';
//Ejemplo de cómo obtener todos los intentos de un usuarios para una pregunta en una quiz en particular.
$intentosDeUnAlumno = DAOFactory::getIntentosDAO()->getIntentosByUsuarioQuizPregunta(551, 3, 3);

/**
* Para agregar funciones, por ejemplo, en intentos, se debe declarar la interfaz en /class/dao/IntentosDAO.class.php
* y luego construir la consulta en /class/mysql/IntentosMySqlDAO.class.php
**/


//TODO: definir todas las consultas que se requeriran para agregarlas a los DAO

print_r($intentosDeUnAlumno);
print("</br><hr /></br>Fin Prueba");
?>