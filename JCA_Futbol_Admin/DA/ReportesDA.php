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

    function championshipReportById($idCampeonato) {
        $query = "SELECT c.Campeonato, EQ.Grupo, EQ.Nombre, 
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
		COUNT(CASE WHEN EN1.PW = 1 THEN 1 END) + COUNT(CASE WHEN EN2.PW = 1 THEN 1 END) AS PW, 
		(CASE WHEN (SUM(CASE WHEN EN1.PW = 1 THEN 0 
		WHEN EN1.Goles1 > EN1.Goles2 THEN 3 
		WHEN EN1.Goles1 = EN1.Goles2 THEN 2 
		WHEN EN1.Goles1 < EN1.Goles2 THEN 1 END)) IS NULL THEN 0 ELSE (SUM(CASE WHEN EN1.PW = 1 THEN 0 
		WHEN EN1.Goles1 > EN1.Goles2 THEN 3 
		WHEN EN1.Goles1 = EN1.Goles2 THEN 2 
		WHEN EN1.Goles1 < EN1.Goles2 THEN 1 END)) END) + (CASE WHEN (SUM(CASE WHEN EN2.PW = 1 THEN 0 
		WHEN EN2.Goles2 > EN2.Goles1 THEN 3 
		WHEN EN2.Goles2 = EN2.Goles1 THEN 2 
		WHEN EN2.Goles2 < EN2.Goles1 THEN 1 END)) IS NULL THEN 0 ELSE (SUM(CASE WHEN EN2.PW = 1 THEN 0 
		WHEN EN2.Goles2 > EN2.Goles1 THEN 3 
		WHEN EN2.Goles2 = EN2.Goles1 THEN 2 
		WHEN EN2.Goles2 < EN2.Goles1 THEN 1 END)) END) AS PTOS
		FROM equipos AS EQ 
		LEFT OUTER JOIN resultados AS EN1 ON EQ.IdEquipo = EN1.IdEquipo1
		LEFT OUTER JOIN resultados AS EN2 ON EQ.IdEquipo = EN2.IdEquipo2
		inner join campeonatos as c on EQ.IdCampeonato = c.IdCampeonato
		where c.IdCampeonato = " . $idCampeonato . " " .
		"GROUP BY EQ.Nombre, EQ.IdCampeonato, EQ.Grupo, EN1.IdEquipo1, EQ.IdEquipo
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

}
