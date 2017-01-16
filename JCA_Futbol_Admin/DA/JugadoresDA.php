<?php

/**
 * Conexion a la BD para el objeto Equipos
 * @author Sebastian Melo
 * @created 12/01/2017
 * @copyright DG Solutions sas
 */
class JugadoresDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function obtenerJugadores() {
        
        //var imagen = 'CONCAT('<img src="Uploads/',Url,'"" class="img-circle profile_img2">')''''';
        $query = "SELECT J.IdJugador AS IdJugador, J.NombreJugador AS NombreJugador, J.Documento AS Documento, J.CorreoElectronico AS CorreoElectronico, J.Celular AS Celular, IF(J.DirectorTecnico=0,' ','checked' )AS DT, IF(J.Delegado=0,' ','checked') As Delegado, IF(J.RepresentanteLegal=0,' ','checked') As RepresentanteLegal,Url AS Url
FROM Jugador J ";
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
	
	function eliminarJugador($idJugadorEliminar)
    {
        $resul=mysqli_query($this->db->Connect(),"delete from Jugador where IdJugador = " . $idJugadorEliminar);
    }
    
    function registrarJugador($NombreJugador, $Documento, $CorreoElectronico, $Celular, $DirectorTecnico, $Delegado, $RepresentanteLegal,$Url)
    { 
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO Jugador (NombreJugador, Documento, CorreoElectronico, Celular, DirectorTecnico, Delegado, RepresentanteLegal,Url) VALUES ("
                . "'" . $NombreJugador . "',"
                . $Documento . ","
                . "'" . $CorreoElectronico . "',"
                . $Celular . ","
                . $DirectorTecnico . ","
                . $Delegado . ","
                . $RepresentanteLegal . ","
                . "'" . $Url . "')"
        );
    }
    
}
