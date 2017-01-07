<?php

/**
 * Conexion a la BD para el objeto Campeonatos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class ResultadosDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerResultados() {
        $query = "SELECT R.IdResultado AS IdResultado, F.nombre_fecha AS Fecha, C.Campeonato AS Campeonato, E.Nombre AS Equipo_1, E1.Nombre AS Equipo_2, R.Goles1 AS GolesE1, R.Goles2 AS GolesE2 FROM resultados R INNER JOIN fechas F ON R.idFecha=F.IdFecha INNER JOIN campeonatos C ON R.idCampeonato=C.idCampeonato INNER JOIN equipos E ON R.IdEquipo1=E.IdEquipo INNER JOIN equipos E1 ON R.IdEquipo2=E1.IdEquipo ";
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

    function guardarResultado($idFecha, $idCampeonato, $IdEquipo1, $IdEquipo2, $Goles1, $Goles2) 
    {                  
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO resultados (IdFecha, IdCampeonato, IdEquipo1, IdEquipo2, Goles1, Goles2) VALUES ("
                . $idFecha . ","
                . $idCampeonato . ","
                . $IdEquipo1 . ","
                . $IdEquipo2 . ","
                . $Goles1 . ","
                . $Goles2 . ")"
        );
    }

   function eliminarResultado($IdResultado)
    {
        $resul=mysqli_query($this->db->Connect(),"delete from resultados where IdResultado = " . $IdResultado);
    }
}
