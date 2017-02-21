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

    function guardarResultado($idFecha, $idCampeonato, $IdEquipo1, $IdEquipo2, $Goles1, $Goles2) {
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO resultados (IdFecha, IdCampeonato, IdEquipo1, IdEquipo2, Goles1, Goles2) VALUES ("
                . $idFecha . ","
                . $idCampeonato . ","
                . $IdEquipo1 . ","
                . $IdEquipo2 . ","
                . $Goles1 . ","
                . $Goles2 . ")"
        );
    }

    function eliminarResultado($IdResultado) {
        $resul = mysqli_query($this->db->Connect(), "delete from resultados where IdResultado = " . $IdResultado);
    }

    function obtenerResultadosJL($IdEquipo1) {
        $query = "SELECT J.IdJugador AS id, J.NombreJugador AS nombre FROM tblequiposjugadores EJ INNER JOIN jugador J ON EJ.Idjugador=J.idjugador WHERE EJ.idEquipo= $IdEquipo1 ";
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

    function obtenerResultadosJL1($IdEquipo2) {
        $query = "SELECT J.IdJugador AS id, J.NombreJugador AS nombre FROM tblequiposjugadores EJ INNER JOIN jugador J ON EJ.Idjugador=J.idjugador WHERE EJ.idEquipo= $IdEquipo2 ";
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
    
    function guardarDetalle($idJugador, $Amarilla, $Azul, $Roja, $Goles, $IdEquipo) {
        
        $IdResultado1 = mysqli_query($this->db->Connect(), "SELECT MAX(IdResultado) AS id FROM resultados");
        $fila = mysqli_fetch_array($IdResultado1);		
		
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO resultadodetalle (IdJugador, IdResultado, Amarilla, Azul, Roja, Goles, IdEquipo) VALUES ("
                . $idJugador . ","
                . $fila['id']. ","
                //. $idResultado2['IdResultado'] . ","
                . $Amarilla . ","
                . $Azul . ","
                . $Roja . ","
                . $Goles . ","
                . $IdEquipo . ")"
        );
    }
    
    function guardarResultadoEditado($IdResultado, $idFecha, $idCampeonato, $IdEquipo1, $IdEquipo2, $Goles1, $Goles2) {
            $resul = mysqli_query($this->db->Connect(), "UPDATE resultados SET IdFecha='" . $idFecha . "', IdCampeonato='" . $idCampeonato . "', IdEquipo1='"  . $IdEquipo1 . "', IdEquipo2='" . $IdEquipo2 . "', Goles1='" . $Goles1 . "', Goles2='"  . $Goles2 . "' WHERE IdResultado=".$IdResultado);
        //$resul = mysqli_query($this->db->Connect(), "UPDATE resultados SET IdFecha=". "'" . $idFecha . "', IdCampeonato=". "'" . //$idCampeonato . "', IdEquipo1="  . $IdEquipo1 . "', IdEquipo2="  . $IdEquipo2 . "', Goles1="  . $Goles1 . "', Goles2="  . $Goles2 //. " WHERE IdResultado=".$IdResultado);
        }

    
    function obtenerResultadoseditadosJL($IdResultado, $IdEquipo) {
        $query = "SELECT RD.IdJugador AS id, J.NombreJugador AS nombre, RD.Goles AS Goles, RD.Amarilla AS amarilla, RD.Azul AS azul, RD.Roja AS roja FROM resultadodetalle RD INNER JOIN jugador J ON RD.IdJugador=J.IdJugador WHERE RD.IdResultado = $IdResultado AND RD.IdEquipo = $IdEquipo ";
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
    
    function obtenerResultadoseditadosJL1($IdResultado) {
        $query = "SELECT RD.IdJugador AS id, J.NombreJugador AS nombre, RD.Goles AS Goles, RD.Amarilla AS amarilla, RD.Azul AS azul, RD.Roja AS roja FROM resultadodetalle RD INNER JOIN jugador J ON RD.IdJugador=J.IdJugador WHERE RD.IdResultado = $IdResultado";
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
    
    function obtenerResultadosdetallee1($IdResultado, $IdEquipo){
        $query = "SELECT J.NombreJugador AS Name, RD.Goles AS Goals, RD.Amarilla AS amarilla, RD.Azul AS azul, RD.Roja AS roja FROM resultadodetalle RD INNER JOIN jugador J ON RD.IdJugador=J.IdJugador WHERE RD.IdResultado = $IdResultado AND (Select IdEquipo FROM Equipos WHERE Nombre = '$IdEquipo')=RD.IdEquipo ";
        //($query);
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
    
    function obtenerResultadosdetallee2($IdResultado, $IdEquipo){
        $query = "SELECT J.NombreJugador AS Name, RD.Goles AS Goals, RD.Amarilla AS amarilla, RD.Azul AS azul, RD.Roja AS roja FROM resultadodetalle RD INNER JOIN jugador J ON RD.IdJugador=J.IdJugador WHERE RD.IdResultado = $IdResultado AND (Select IdEquipo FROM Equipos WHERE Nombre = '$IdEquipo')=RD.IdEquipo ";
        //($query);
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
}
