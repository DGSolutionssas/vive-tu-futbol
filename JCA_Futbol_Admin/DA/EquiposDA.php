<?php

/**
 * Conexion a la BD para el objeto Equipos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class EquiposDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerEquipos() {
        $query = "SELECT E.idEquipo AS IdEquipo, C.Campeonato AS Campeonato, E.Nombre AS Nombre, E.Descripcion AS Descripcion, E.Puntos AS Puntos, E.Grupo AS Grupo FROM equipos E INNER JOIN campeonatos C ON E.idCampeonato=C.idCampeonato";
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
	
	function eliminarEquipo($idEquipoEliminar)
    {
        $resul=mysqli_query($this->db->Connect(),"delete from equipos where IdEquipo = " . $idEquipoEliminar);
    }
    
    function registrarEquipoCampeonato($idCampeonato, $nombreEquipo, $descripcionEquipo, $idGrupo)
    {
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO Equipos (IdCampeonato, Nombre, Descripcion, Grupo) VALUES ("
                . $idCampeonato . ","
                . "'" . $nombreEquipo. "',"
                . "'" . $descripcionEquipo . "',"
                . $idGrupo . ")"
        );
    }
    function autocompletarEquipo($Equipo, $IdCampeonato) {
        $query = "SELECT idEquipo,Nombre FROM equipos WHERE Nombre LIKE '%" . $Equipo . "%' AND IdCampeonato = $IdCampeonato";
        mysqli_set_charset($this->db->Connect(), "utf8");
        $resul = mysqli_query($this->db->Connect(), $query);
        $nrows = mysqli_num_rows($resul);

        $return_arr = array();
        if ($nrows > 0) {
            while ($row =  mysqli_fetch_array($resul, MYSQLI_ASSOC)) {
                $row_array['id'] = $row['idEquipo'];
                $row_array['value'] = $row['Nombre'];

                array_push($return_arr, $row_array);
            }
            return $return_arr;
        } else {
            return "";
        }
    }
}
