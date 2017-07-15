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
j.idJugador AS IdJugador
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
j.idJugador AS IdJugador
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
j.idJugador AS IdJugador
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
j.idJugador AS IdJugador
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
        $query = "SELECT EQ.Grupo, EQ.Nombre,(SELECT COUNT(*) FROM resultados WHERE idequipo1=EQ.idEquipo OR idequipo2=EQ.idEquipo) AS PJ,
((SELECT (COUNT(CASE WHEN Goles1 > Goles2 THEN 1 END)) FROM resultados
WHERE IDEQUIPO1=EQ.idEquipo) 
+
(SELECT (COUNT(CASE WHEN Goles2 > Goles1 THEN 1 END)) FROM resultados
WHERE IDEQUIPO2=EQ.idEquipo)
 ) AS PG,
 ((SELECT (COUNT(CASE WHEN Goles1 = Goles2 THEN 1 END)) FROM resultados
WHERE IDEQUIPO1=EQ.idEquipo) 
+
(SELECT (COUNT(CASE WHEN Goles2 = Goles1 THEN 1 END)) FROM resultados
WHERE IDEQUIPO2=EQ.idEquipo)
 ) AS PE,
 ((SELECT (COUNT(CASE WHEN Goles1 < Goles2 THEN 1 END)) FROM resultados
WHERE IDEQUIPO1=EQ.idEquipo) 
+
(SELECT (COUNT(CASE WHEN Goles2 < Goles1 THEN 1 END)) FROM resultados
WHERE IDEQUIPO2=EQ.idEquipo)
 ) AS PP,
 ( CASE WHEN 
		(
			SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo)
		END
		+
		 CASE WHEN 
		(
			SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo)
			
		END )AS GF,
 ( CASE WHEN 
		(
			SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo)
		END
		+
		 CASE WHEN 
		(
			SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo)
			
		END )AS GC,
		(
		( CASE WHEN 
		(
			SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo)
		END
		+
		 CASE WHEN 
		(
			SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo)
			
		END )
		-
		( CASE WHEN 
		(
			SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles2) FROM resultados
			WHERE IDEQUIPO1=EQ.idEquipo)
		END
		+
		 CASE WHEN 
		(
			SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo
		) IS NULL THEN 0 ELSE (SELECT SUM(Goles1) FROM resultados
			WHERE IDEQUIPO2=EQ.idEquipo)
			
		END )) AS DG,
		(
(SELECT SUM(CASE Amarilla WHEN 1 THEN 2 ELSE 0 END)  FROM resultadodetalle
WHERE idEquipo=EQ.idEquipo)
+
(SELECT SUM(CASE Roja WHEN 1 THEN 10 ELSE 0 END)  FROM resultadodetalle
WHERE idEquipo=EQ.idEquipo))AS JL
,
((
SELECT COUNT(*) FROM resultados
WHERE EquipoGanador=1 AND idEquipo1=EQ.idEquipo)
+
((
SELECT COUNT(*) FROM resultados
WHERE EquipoGanador=2 AND idEquipo2=EQ.idEquipo
))
) AS PW,
((
	(
		(SELECT COUNT(CASE WHEN Goles1 > Goles2 THEN 1 END) FROM resultados WHERE idequipo1=EQ.idEquipo)*3
	)
	+
	(
		(SELECT COUNT(CASE WHEN Goles1 = Goles2 THEN 1 END) FROM resultados WHERE idequipo1=EQ.idEquipo)*2
	)
	+
	(
		(SELECT COUNT(CASE WHEN Goles1 < Goles2 THEN 1 END) FROM resultados WHERE idequipo1=EQ.idEquipo AND EquipoGanador=0)
	)
)
+
(
	(
		(SELECT COUNT(CASE WHEN Goles2 > Goles1 THEN 1 END) FROM resultados WHERE idequipo2=EQ.idEquipo)*3
	)
	+
	(
		(SELECT COUNT(CASE WHEN Goles2 = Goles1 THEN 1 END) FROM resultados WHERE idequipo2=EQ.idEquipo)*2
	)
	+
	(
		(SELECT COUNT(CASE WHEN Goles2 < Goles1 THEN 1 END) FROM resultados WHERE idequipo2=EQ.idEquipo AND EquipoGanador=0)
	)
)
) AS PTOS
 FROM equipos AS EQ
 WHERE EQ.IdCampeonato=$idCampeonato AND EQ.Grupo=$grupo;";

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
