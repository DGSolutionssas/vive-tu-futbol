<?php

/**
 * Conexion a la BD para generar las reportes
 * @author gustavo gonzález
 * @created 07/01/2017
 * @copyright DG Solutions sas
 */
class ReportesDA {

    private $db;

    function __construct() {
        require_once 'Connect.php';
        $this->db = new Connect();
    }

    function championshipNameById($idCampeonato) {
        $query = "select c.Campeonato, c.Grupos from campeonatos c
		where c.IdCampeonato = " . $idCampeonato . ";";

        mysqli_set_charset($this->db->Connect(), "utf8");
        $resul = mysqli_query($this->db->Connect(), $query);
        $nrows = mysqli_num_rows($resul);

        $jsonData = array();
        if ($nrows > 0) {
            while ($row = mysqli_fetch_array($resul)) {
                $_SESSION['nombreCampeonato'] = $row['Campeonato'];
                $_SESSION['Grupos'] = $row['Grupos'];
            }
        }
    }

    function championshipFairPlayReportById($idCampeonato, $grupo) {
        //$query = "SELECT c.Campeonato, EQ.Grupo, EQ.Nombre,
        $query = "SELECT EQ.Grupo, EQ.Nombre as Equipo,
		(SELECT SUM(CASE JL.Amarilla WHEN 1 THEN 2 ELSE 0 END) +
		SUM(CASE JL.Roja WHEN 1 THEN 10 ELSE 0 END) +
		SUM(CASE JL.Azul WHEN 1 THEN 4 ELSE 0 END) AS Expr1
		FROM equipos AS EQ1
		LEFT OUTER JOIN tblequiposjugadores AS JU ON EQ1.IdEquipo = JU.IdEquipo
		LEFT OUTER JOIN resultadodetalle AS JL ON JL.IdJugador = JU.IdJugador
		WHERE (EQ.IdEquipo = EQ1.IdEquipo)) AS ptos
		FROM equipos AS EQ
		LEFT OUTER JOIN resultados AS EN1 ON EQ.IdEquipo = EN1.IdEquipo1
		LEFT OUTER JOIN resultados AS EN2 ON EQ.IdEquipo = EN2.IdEquipo2
		inner join campeonatos as c on EQ.IdCampeonato = c.IdCampeonato
		where c.IdCampeonato = " . $idCampeonato . " " . "and EQ.Grupo = " . $grupo .
                " GROUP BY EQ.Nombre, EQ.IdCampeonato, EQ.Grupo, EN1.IdEquipo1, EQ.IdEquipo
		order by ptos desc;";

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

    function fairPlayReportPlayers($idCampeonato) {
        /* $query = "select DISTINCT f.IdFecha, UPPER(e.Nombre) as Equipo, UPPER(j.NombreJugador) AS NombreJugador,
          CASE rd.Amarilla WHEN 1 THEN 2 ELSE 0 END as Amarilla,
          CASE rd.Roja WHEN 1 THEN 10 ELSE 0 END as Roja,
          CASE rd.Azul WHEN 1 THEN 4 ELSE 0 END as Azul,
          J.idJugador AS IdJugador
          from resultadodetalle rd
          inner join resultados r on rd.IdResultado = r.IdResultado
          inner join equipos e on rd.IdEquipo = e.IdEquipo
          inner join jugador j on rd.IdJugador = j.IdJugador
          inner join fechas f on r.IdFecha = f.IdFecha
          where f.idCampeonato = " . $idCampeonato .
          " AND j.idJugador in (75,76) order by f.nombre_fecha asc;";
         * */
        $query = "SELECT DISTINCT f.IdFecha, UPPER(e.Nombre) AS Equipo, UPPER(j.NombreJugador) AS NombreJugador,
CASE rd.Amarilla WHEN 1 THEN 2 ELSE 0 END AS Amarilla,
CASE rd.Roja WHEN 1 THEN 10 ELSE 0 END AS Roja,
CASE rd.Azul WHEN 1 THEN 4 ELSE 0 END AS Azul,
J.idJugador AS IdJugador
FROM resultadodetalle rd
INNER JOIN resultados r ON rd.IdResultado = r.IdResultado
INNER JOIN equipos e ON rd.IdEquipo = e.IdEquipo
INNER JOIN jugador j ON rd.IdJugador = j.IdJugador
INNER JOIN fechas f ON r.IdFecha = f.IdFecha
WHERE f.idCampeonato = " . $idCampeonato . " 
AND (rd.Roja != 0  OR rd.Amarilla != 0 OR rd.Azul != 0)".
//AND j.idJugador IN (75,76,80,734,150) 
" ORDER BY IdJugador,IdFecha ASC;";

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

    function seleccionarJugadores($idCampeonato) {
        $query = "SELECT DISTINCT
J.idJugador AS IdJugador
FROM resultadodetalle rd
INNER JOIN resultados r ON rd.IdResultado = r.IdResultado
INNER JOIN equipos e ON rd.IdEquipo = e.IdEquipo
INNER JOIN jugador j ON rd.IdJugador = j.IdJugador
INNER JOIN fechas f ON r.IdFecha = f.IdFecha
WHERE f.idCampeonato IN ($idCampeonato)
AND (rd.Roja != 0  OR rd.Amarilla != 0 OR rd.Azul != 0)".
//AND j.idJugador IN (75,76,80,734,150) 
" ORDER BY IdJugador ASC;";

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

    function datosJugadorAmonestado($idJugador,$idCampeonato) {
        $query = "SELECT DISTINCT UPPER(e.Nombre) AS Equipo, UPPER(j.NombreJugador) AS NombreJugador,
J.idJugador AS IdJugador
FROM resultadodetalle rd
INNER JOIN resultados r ON rd.IdResultado = r.IdResultado
INNER JOIN equipos e ON rd.IdEquipo = e.IdEquipo
INNER JOIN jugador j ON rd.IdJugador = j.IdJugador
INNER JOIN fechas f ON r.IdFecha = f.IdFecha
WHERE f.idCampeonato=$idCampeonato
AND j.idJugador = $idJugador";

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
    
    function reporteTarjetas($idCampeonato, $idJugador)
    {
        $query="SELECT DISTINCT f.IdFecha, CASE rd.Amarilla WHEN 1 THEN 2 ELSE 0 END AS Amarilla,
CASE rd.Roja WHEN 1 THEN 10 ELSE 0 END AS Roja,
CASE rd.Azul WHEN 1 THEN 4 ELSE 0 END AS Azul,
J.idJugador AS IdJugador
FROM resultadodetalle rd
INNER JOIN resultados r ON rd.IdResultado = r.IdResultado
INNER JOIN equipos e ON rd.IdEquipo = e.IdEquipo
INNER JOIN jugador j ON rd.IdJugador = j.IdJugador
INNER JOIN fechas f ON r.IdFecha = f.IdFecha
WHERE f.idCampeonato IN ($idCampeonato)
AND (rd.Roja != 0  OR rd.Amarilla != 0 OR rd.Azul != 0)
AND j.idJugador =$idJugador 
ORDER BY IdJugador,IdFecha ASC;";
        
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

    function fairPlayReportPlayersforPlayer($idCampeonato, $idJugador, $idFecha) {
        $query = "SELECT IdFecha, Equipo, NombreJugador, Amarilla, Roja, Azul, IdJugador
             FROM (SELECT f.IdFecha, UPPER(e.Nombre) AS Equipo, UPPER(j.NombreJugador) AS NombreJugador,
		CASE rd.Amarilla WHEN 1 THEN 2 ELSE 0 END AS Amarilla,
		CASE rd.Roja WHEN 1 THEN 10 ELSE 0 END AS Roja,
		CASE rd.Azul WHEN 1 THEN 4 ELSE 0 END AS Azul,
		J.idJugador AS IdJugador
		FROM resultadodetalle rd
		INNER JOIN resultados r ON rd.IdResultado = r.IdResultado
		INNER JOIN equipos e ON rd.IdEquipo = e.IdEquipo
		INNER JOIN jugador j ON rd.IdJugador = j.IdJugador
		INNER JOIN fechas f ON r.IdFecha = f.IdFecha
		WHERE f.idCampeonato = " . $idCampeonato . " ORDER BY idFecha ASC) nuevo 
		WHERE IdJugador=" . $idJugador . " AND IdFecha=" . $idFecha . ";";
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

    function championshipReportById($idCampeonato, $grupo) {
        //$query = "SELECT c.Campeonato, EQ.Grupo, EQ.Nombre,
        $query = "SELECT EQ.Grupo, EQ.Nombre,
		COUNT(DISTINCT EN1.IdResultado) + COUNT(DISTINCT EN2.IdResultado) AS PJ,
		COUNT(CASE WHEN EN1.Goles1 > EN1.Goles2 THEN 1 END) + COUNT(CASE WHEN EN2.Goles2 > EN2.Goles1 THEN 1 END) AS PG,
		COUNT(CASE WHEN EN1.Goles1 = EN1.Goles2 THEN 1 END) + COUNT(CASE WHEN EN2.Goles2 = EN2.Goles1 THEN 1 END) AS PE,
		COUNT(CASE WHEN EN1.Goles1 < EN1.Goles2 THEN 1 END) + COUNT(CASE WHEN EN2.Goles2 < EN2.Goles1 THEN 1 END) AS PP,
		(CASE WHEN SUM(EN1.Goles1) IS NULL THEN 0 ELSE SUM(EN1.Goles1) END) + (CASE WHEN SUM(EN2.Goles2) IS NULL THEN 0 ELSE SUM(EN2.Goles2) END) AS GF,
		(CASE WHEN SUM(EN1.Goles2) IS NULL THEN 0 ELSE SUM(EN1.Goles2) END) + (CASE WHEN SUM(EN2.Goles1) IS NULL THEN 0 ELSE SUM(EN2.Goles1) END) AS GC,
		(CASE WHEN SUM(EN1.Goles1 - EN1.Goles2) IS NULL THEN 0 ELSE SUM(EN1.Goles1 - EN1.Goles2) END) + (CASE WHEN SUM(EN2.Goles2 - EN2.Goles1) IS NULL THEN 0 ELSE SUM(EN2.Goles2 - EN2.Goles1) END) AS DG,
		(SELECT SUM(CASE JL.Amarilla WHEN 1 THEN 2 ELSE 0 END) + SUM(CASE JL.Roja WHEN 1 THEN 10 ELSE 0 END) + SUM(CASE JL.Azul WHEN 1 THEN 4 ELSE 0 END) AS Expr1
		FROM equipos AS EQ1
		LEFT OUTER JOIN tblequiposjugadores AS JU ON EQ1.IdEquipo = JU.IdEquipo
		LEFT OUTER JOIN resultadodetalle AS JL ON JL.IdJugador = JU.IdJugador
		WHERE (EQ.IdEquipo = EQ1.IdEquipo)) AS JL,
		COUNT(CASE WHEN EN1.EquipoGanador = 1 THEN 1 END) + COUNT(CASE WHEN EN2.EquipoGanador = 2 THEN 1 END) AS PW,
		(CASE WHEN (SUM(CASE WHEN EN1.EquipoGanador = 1 THEN 3
		WHEN EN2.EquipoGanador = 2 THEN 0
		WHEN EN1.Goles1 > EN1.Goles2 THEN 3
		WHEN EN1.Goles1 = EN1.Goles2 THEN 2
		WHEN EN1.Goles1 < EN1.Goles2 AND EN1.EquipoGanador=0 THEN 1 END)) IS NULL THEN 0 ELSE (SUM(CASE WHEN EN1.EquipoGanador = 1 THEN 3
		WHEN EN2.EquipoGanador = 2 THEN 0
		WHEN EN1.Goles1 > EN1.Goles2 THEN 3
		WHEN EN1.Goles1 = EN1.Goles2 THEN 2
		WHEN EN1.Goles1 < EN1.Goles2 AND EN1.EquipoGanador=0 THEN 1 END)) END) + (CASE WHEN (SUM(CASE WHEN EN2.EquipoGanador = 2 THEN 3
		WHEN EN2.EquipoGanador = 1 THEN 0
		WHEN EN2.Goles2 > EN2.Goles1 THEN 3
		WHEN EN2.Goles2 = EN2.Goles1 THEN 2
		WHEN EN2.Goles2 < EN2.Goles1 AND EN2.EquipoGanador=0 THEN 1 END)) IS NULL THEN 0 ELSE (SUM(CASE WHEN EN2.EquipoGanador = 2 THEN 3
		WHEN EN2.EquipoGanador = 1 THEN 0
		WHEN EN2.Goles2 > EN2.Goles1 THEN 3
		WHEN EN2.Goles2 = EN2.Goles1 THEN 2
		WHEN EN2.Goles2 < EN2.Goles1 AND EN2.EquipoGanador=0 THEN 1 END)) END) AS PTOS
		FROM equipos AS EQ
		LEFT OUTER JOIN resultados AS EN1 ON EQ.IdEquipo = EN1.IdEquipo1
		LEFT OUTER JOIN resultados AS EN2 ON EQ.IdEquipo = EN2.IdEquipo2
		INNER JOIN campeonatos AS c ON EQ.IdCampeonato = c.IdCampeonato
		WHERE c.IdCampeonato = " . $idCampeonato . " " .
                "AND EQ.Grupo =  " . $grupo . " GROUP BY EQ.Nombre, EQ.IdCampeonato, EQ.Grupo, EN1.IdEquipo1, EQ.IdEquipo
		ORDER BY ptos DESC;";

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

    function goalsReportById($idCampeonato) {
        $query = "select UPPER(j.NombreJugador) as NombreJugador, UPPER(e.Nombre) as nombreEquipo, SUM( rd.Goles ) AS Goles
		from resultados r
		inner join resultadodetalle rd on r.IdResultado = rd.IdResultado
		inner join jugador j on rd.IdJugador = j.IdJugador
		inner join tblequiposjugadores er on j.IdJugador = er.IdJugador
		inner join equipos e on er.IdEquipo = e.IdEquipo
		inner join campeonatos c on e.IdCampeonato = c.IdCampeonato
		where c.IdCampeonato = " . $idCampeonato . " " .
                "GROUP BY NombreJugador, nombreEquipo ORDER BY Goles DESC;";

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

    function datosJugador($idJugador) {
        $query = "SELECT J.Documento AS Documento, UPPER(J.NombreJugador) AS NombreJugador, UPPER(E.Nombre) AS Equipo, UPPER(C.Campeonato) AS Campeonato FROM jugador J
              INNER JOIN tblequiposjugadores EJ ON J.IdJugador=EJ.IdJugador
              INNER JOIN equipos E ON EJ.IdEquipo = E.IdEquipo
              INNER JOIN campeonatos C ON E.IdCampeonato=C.IdCampeonato
              WHERE J.IdJugador=$idJugador
              LIMIT 1";

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
