<?php

/**
 * Conexion a la BD para el objeto Campeonatos
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class CampeonatosDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerCampeonatos() {
        $query = "SELECT IdCampeonato, Campeonato, Descripcion, Grupos, Equipos, CantidadJugadores FROM campeonatos";

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

    function eliminarCampeonato($IdCampeonato) {
        $resul = mysqli_query($this->db->Connect(),"DELETE FROM jugador WHERE idJugador IN (SELECT idJugador FROM tblequiposjugadores WHERE idEquipo IN (SELECT IdEquipo FROM EQUIPOS WHERE IdCampeonato=".$IdCampeonato."))");
        $resul = mysqli_query($this->db->Connect(),"DELETE FROM tblequiposjugadores WHERE IdEquipo IN (SELECT IdEquipo FROM EQUIPOS WHERE IdCampeonato=".$IdCampeonato.")");
        $resul = mysqli_query($this->db->Connect(),"DELETE FROM fechas WHERE idCampeonato=".$IdCampeonato);
        $resul = mysqli_query($this->db->Connect(),"DELETE FROM resultadodetalle WHERE IdResultado IN (SELECT idResultado FROM resultados WHERE idCampeonato=".$IdCampeonato.")");
        $resul = mysqli_query($this->db->Connect(),"DELETE FROM resultados WHERE idCampeonato=".$IdCampeonato);
        $resul = mysqli_query($this->db->Connect(),"DELETE FROM equipos WHERE idCampeonato=".$IdCampeonato);
        $resul = mysqli_query($this->db->Connect(),"DELETE FROM campeonatos WHERE idCampeonato=".$IdCampeonato);
    }

    function obtenerGruposCampeonato($idCampeonato) {
        $query = "SELECT Grupos FROM campeonatos WHERE idCampeonato=" . $idCampeonato;

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

    function guardarCampeonato($dtoCampeonato) {
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO campeonatos (Campeonato, Descripcion, Grupos, Equipos, CantidadJugadores) VALUES ("
                . "'" . $dtoCampeonato->getCampeonato() . "',"
                . "'" . $dtoCampeonato->getDescripcion() . "',"
                . "" . $dtoCampeonato->getGrupos() . ","
                . $dtoCampeonato->getEquipos() . ","
                . $dtoCampeonato->getCantidadJugadores() . ")"
        );
    }

    function autocompletarCampeonato($campeonato) {
        $query = "SELECT idCampeonato,campeonato FROM campeonatos WHERE campeonato LIKE '%" . $campeonato . "%'";
        mysqli_set_charset($this->db->Connect(), "utf8");
        $resul = mysqli_query($this->db->Connect(), $query);
        $nrows = mysqli_num_rows($resul);

        $return_arr = array();
        if ($nrows > 0) {
            while ($row = mysqli_fetch_array($resul, MYSQLI_ASSOC)) {
                $row_array['id'] = $row['idCampeonato'];
                $row_array['value'] = $row['campeonato'];

                array_push($return_arr, $row_array);
            }
            return $return_arr;
        } else {
            return "";
        }
    }
    
     function actualizarCampeonato(CampeonatosDTO $dtoCampeonato) {
         
        $resul = mysqli_query($this->db->Connect(), "UPDATE campeonatos SET "
                . " Campeonato ='".$dtoCampeonato->getCampeonato()."'"
                . " ,Descripcion='".$dtoCampeonato->getDescripcion()."'"
                . " ,Grupos=".$dtoCampeonato->getGrupos()
                . " ,Equipos=".$dtoCampeonato->getEquipos()
                . " ,CantidadJugadores=".$dtoCampeonato->getCantidadJugadores()
                . " WHERE IdCampeonato=".$dtoCampeonato->getIdCampeonato());
     }
}
