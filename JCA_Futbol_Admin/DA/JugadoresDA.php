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
FROM jugador J ";
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
    function obtenerJugadoresFiltro($idEquipo) {

        //var imagen = 'CONCAT('<img src="Uploads/',Url,'"" class="img-circle profile_img2">')''''';
        $query = "SELECT J.IdJugador AS IdJugador, J.NombreJugador AS NombreJugador, J.Documento AS Documento, J.CorreoElectronico AS CorreoElectronico, J.Celular AS Celular, IF(J.DirectorTecnico=0,' ','checked' )AS DT, IF(J.Delegado=0,' ','checked') As Delegado, IF(J.RepresentanteLegal=0,' ','checked') As RepresentanteLegal,Url AS Url
        FROM jugador J
        INNER JOIN tblequiposjugadores T ON J.IdJugador = T.IdJugador
        WHERE T.IdEquipo = ".$idEquipo;
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
        $resul=mysqli_query($this->db->Connect(),"DELETE FROM jugador WHERE IdJugador = " . $idJugadorEliminar);
        $resul2=mysqli_query($this->db->Connect(),"DELETE FROM tblequiposjugadores WHERE IdJugador =  " . $idJugadorEliminar);
    }

    function registrarJugador($NombreJugador, $Documento, $CorreoElectronico, $Celular, $DirectorTecnico, $Delegado, $RepresentanteLegal,$Url,$idEquipoSeleccionado)
    {
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO jugador (NombreJugador, Documento, CorreoElectronico, Celular, DirectorTecnico, Delegado, RepresentanteLegal,Url) VALUES ("
                . "'" . $NombreJugador . "',"
                . $Documento . ","
                . "'" . $CorreoElectronico . "',"
                . $Celular . ","
                . $DirectorTecnico . ","
                . $Delegado . ","
                . $RepresentanteLegal . ","
                . "'" . $Url . "')"
        );
        $resul = mysqli_query($this->db->Connect(), "INSERT INTO tblequiposjugadores(IdEquipo, IdJugador) VALUES ( ". $idEquipoSeleccionado . ",(SELECT MAX(IdJugador) AS IdJugador FROM jugador))"
        );
    }
    function ActualizarJugador($idJugadorEditar,$NombreJugadorEditar, $DocumentoEditar, $CorreoElectronicoEditar, $CelularEditar, $DirectorTecnicoEditar, $DelegadoEditar, $RepresentanteLegalEditar,$UrlEditar)
    {

       if($UrlEditar)
       {
            $resul = mysqli_query($this->db->Connect(),  "UPDATE jugador SET NombreJugador='" . $NombreJugadorEditar . "', Documento=" . $DocumentoEditar .", CorreoElectronico = '".$CorreoElectronicoEditar."', Celular=".$CelularEditar.", DirectorTecnico=".$DirectorTecnicoEditar.",Delegado=".$DelegadoEditar.", RepresentanteLegal=".$RepresentanteLegalEditar.", Url='".$UrlEditar."' WHERE IdJugador= ".$idJugadorEditar);
       }
       else
       {
           $resul = mysqli_query($this->db->Connect(),  "UPDATE jugador SET NombreJugador='" . $NombreJugadorEditar . "', Documento=" . $DocumentoEditar .", CorreoElectronico = '".$CorreoElectronicoEditar. "', Celular=".$CelularEditar.", DirectorTecnico=".$DirectorTecnicoEditar.",Delegado=".$DelegadoEditar.", RepresentanteLegal=".$RepresentanteLegalEditar." WHERE IdJugador= ".$idJugadorEditar);
       }
    }
    function ConsultarEquipos($idCampeonato)
    {
       $query = "SELECT IdEquipo, Nombre FROM equipos WHERE IdCampeonato = " . $idCampeonato ;
      //   $query = "SELECT IdEquipo, Nombre FROM Equipos ";
        mysqli_set_charset($this->db->Connect(), "utf8");
        $resul = mysqli_query($this->db->Connect(), $query);
        $nrows = mysqli_num_rows($resul);

        $return_arr = array();
        if ($nrows > 0) {
            while ($row = mysqli_fetch_array($resul, MYSQLI_ASSOC)) {
                $row_array['id'] = $row['IdEquipo'];
                $row_array['value'] = $row['Nombre'];

                array_push($return_arr, $row_array);
            }
            return $return_arr;
        } else {
            return "";
        }
    }

    function cantidadJugadores($idEquipoSeleccionado)
    {

      $query="SELECT COUNT(*) AS CantidadRegistrados,(SELECT C.CantidadJugadores FROM campeonatos C INNER JOIN equipos E ON C.idCampeonato = E.idCampeonato WHERE E.IdEquipo=".$idEquipoSeleccionado.") AS CantidadMaxima FROM tblequiposjugadores WHERE IdEquipo=".$idEquipoSeleccionado;
        mysqli_set_charset($this->db->Connect(), "utf8");
       $resul = mysqli_query($this->db->Connect(), $query);
       $nrows = mysqli_num_rows($resul);

       $return_arr = array();
       if ($nrows > 0) {
           while ($row = mysqli_fetch_array($resul, MYSQLI_ASSOC)) {
               $row_array['CantidadRegistrados'] = $row['CantidadRegistrados'];
               $row_array['CantidadMaxima'] = $row['CantidadMaxima'];

               array_push($return_arr, $row_array);
           }
           return $return_arr;
       } else {
           return "";
       }
    }
}
