<?php
        define("DB_HOST","127.0.0.1:3306");
	define("DB_USER","root");
	define("DB_PASS","1234567890");
        define("DB_NAME", "jcafutbol");
        define('DB_CHARSET', 'utf-8');
/**
 * Clase conexion a la Base de Datos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class Connect {

    function __construct() {
        
    }

    function __destruct() {
        
    }

    public function Connect() {
        //require_once 'Config.php';
        $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
        if (!$con) {
            $file = fopen("archivo.txt", "a");
            fwrite($file, "Error : " . mysqli_error() . PHP_EOL);
            fclose($file);
        }
        mysqli_select_db($con, DB_NAME);
        return $con;
    }

    public function close() {
        mysqli_close($con);
    }

}
