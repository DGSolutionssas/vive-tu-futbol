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
        $query = "SELECT R.IdResultado AS IdResultado, F.Descripcion AS Fecha, C.Campeonato AS Campeonato, E.Nombre AS Equipo_1, E.Nombre AS Equipo_2, R.Goles1 AS GolesE1, R.Goles2 AS GolesE2 FROM resultados R INNER JOIN fechas F ON R.idFecha=F.IdFecha INNER JOIN campeonatos C ON R.idCampeonato=C.idCampeonato INNER JOIN equipos E ON R.IdEquipo1=E.IdEquipo AND R.IdEquipo1=E.IdEquipo";
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
        $queryfecha = "SELECT IdFecha FROM fechas WHERE Descripcion='".$idFecha."'";
        $resul1 = mysqli_query($this->db->Connect(), $queryfecha);
        $f1 = mysqli_fetch_row($resul1);
        $fila = $f1[0][0];
        
        $querycampeonato = "SELECT IdCampeonato FROM campeonatos WHERE Campeonato='".$idCampeonato."'";
        $resul2 = mysqli_query($this->db->Connect(), $querycampeonato);
        $f2 = mysqli_fetch_row($resul2);
        $fila1 = $f2[0][0];
        
        $queryequipo1 = "SELECT IdEquipo FROM equipos WHERE Nombre='".$IdEquipo1."'";
        $resul3 = mysqli_query($this->db->Connect(), $queryequipo1);
        $f3 = mysqli_fetch_row($resul3);
        $fila2 = $f3[0][0];
        
        $queryequipo2 = "SELECT IdEquipo FROM equipos WHERE Nombre='".$IdEquipo2."'";
        $resul4 = mysqli_query($this->db->Connect(), $queryequipo2);
        $f4 = mysqli_fetch_row($resul4);
        $fila3 = $f4[0][0];
        
        /*echo "query " . "INSERT INTO resultados (IdFecha, IdCampeonato, IdEquipo1, IdEquipo2, Goles1, Goles2) VALUES ("
                . $fila . ","
                . $fila1 . ","
                . $fila2 . ","
                . $fila3 . ","
                . $Goles1 . ","
                . $Goles2 . ")" ;*/
        
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO resultados (IdFecha, IdCampeonato, IdEquipo1, IdEquipo2, Goles1, Goles2) VALUES ("
                . $fila . ","
                . $fila1 . ","
                . $fila2 . ","
                . $fila3 . ","
                . $Goles1 . ","
                . $Goles2 . ")"
        );
    }

   function eliminarResultado($IdResultado)
    {
        $resul=mysqli_query($this->db->Connect(),"delete from resultados where IdResultado = " . $IdResultado);
    }
}
