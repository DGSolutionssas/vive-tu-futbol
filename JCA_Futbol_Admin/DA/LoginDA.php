<?php

/**
 * Conexion a la BD para el objeto Login
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class LoginDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function __destruct() {

    }

    public function getExistenciaUsuario($usuario, $contrasena) {
        $resul = mysqli_query($this->db->Connect(), "Select us.idUsuario, us.usuario, us.nombre FROM usuario us WHERE us.Usuario='" . trim(addslashes($usuario)) . "'AND us.Password='" . trim($contrasena) . "'");
        mysqli_set_charset($this->db->connect(), "utf8");
        $jsonData = array();
        $nrows = mysqli_num_rows($resul);

        $file = fopen("archivo.txt", "a");
        fwrite($file, "Cantidad : " . $nrows . PHP_EOL);
        fclose($file);

        if ($nrows > 0) {
            while ($row = mysqli_fetch_array($resul)) {
                $jsonData[] = $row;
            }
            return $jsonData;
        } else {
             $resul = mysqli_query($this->db->Connect(),"Select 'JUGADOR', J.IdJugador, J.NombreJugador, T.IdEquipo,E.IdCampeonato FROM jugador J 
                INNER JOIN tblequiposjugadores T ON T.IdJugador = J.IdJugador
                INNER JOIN equipos E ON E.IdEquipo = T.IdEquipo
                WHERE J.Celular = '". trim(addslashes($usuario)) ."' AND CONCAT('A', J.Documento, '*') = '". trim($contrasena) ."'AND J.Delegado = 1");
             mysqli_set_charset($this->db->connect(), "utf8");
            $jsonData = array();
            $nrows = mysqli_num_rows($resul);
            if ($nrows > 0) {
                while ($row = mysqli_fetch_array($resul)) {
                $jsonData[] = $row;
                }
                return $jsonData;
            } else {
                return "";
            }
        }
    }

}
