<?php

/**
 * Conexion a la BD para el objeto Equipos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class FechasDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerFechas() {
        $query = "select f.id_fecha as idfecha, f.nombre_fecha as nombrefecha, f.fecha, c.Campeonato from fechas f inner join campeonatos c on f.idCampeonato = c.IdCampeonato";
        mysqli_set_charset($this->db->Connect(), "utf8");
        $resul = mysqli_query($this->db->Connect(), $query);
        $nrows = mysqli_num_rows($resul);

        $jsonData = array();
        if ($nrows > 0) {
            while ($row = mysqli_fetch_array($resul)) {
                $jsonData[] = $row;
            }
            return $jsonData;
        } else {
            return "";
        }
    }
	
	function eliminarFecha($idFechaEliminar)
    {
        $resul=mysqli_query($this->db->Connect(),"delete from fechas where id_fecha = " . $idFechaEliminar);
    }
    
    function registrarFecha($idCampeonato, $nombreFecha, $fecha)
    {
		echo "entra a guardar fecha en bd ";
		echo "INSERT INTO fechas (nombre_fecha, fecha, idCampeonato) VALUES ("
                . "'" . $nombreFecha . "',"
                . "'" . $fecha . "',"
                . $idCampeonato . ")";
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO fechas (nombre_fecha, fecha, idCampeonato) VALUES ("
                . "'" . $nombreFecha . "',"
                . "'" . $fecha . "',"
                . $idCampeonato . ")"
        );
    }
}
