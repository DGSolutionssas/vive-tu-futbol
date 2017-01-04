<?php

/**
 * Clase DTO Resultado
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class ResultadosDTO {

    private $_idResultado = null;
    private $_IdFecha = null;
    private $_IdCampeonato = null;
    private $_IdEquipo1 = null;
    private $_IdEquipo2 = null;
    private $_Goles1 = null;
    private $_Goles2 = null;

    public function getIdResultado() {
        return $this->_idResultado;
    }

    public function setIdResultado($idResultado) {
        $this->_idResultado = $idResultado;
    }

    public function getIdFecha() {
        return $this->_IdFecha;
    }

    public function setIdFecha($IdFecha) {
        $this->_IdFecha = $IdFecha;
    }

    public function getIdCampeonato() {
        return $this->_IdCampeonato;
    }

    public function setIdCampeonato($IdCampeonato) {
        $this->_IdCampeonato = $IdCampeonato;
    }

    public function getIdEquipo1() {
        return $this->_IdEquipo1;
    }

    public function setIdEquipo1($IdEquipo1) {
        $this->_IdEquipo1 = $IdEquipo1;
    }

    public function getIdEquipo2() {
        return $this->_IdEquipo2;
    }

    public function setIdEquipo2($IdEquipo2) {
        $this->_IdEquipo2 = $IdEquipo2;
    }
    
    public function getGoles1() {
        return $this->_Goles1;
    }

    public function setGoles1($Goles1) {
        $this->_Goles1 = $Goles1;
    }
    
     public function getGoles2() {
        return $this->_Goles2;
    }

    public function setGoles2($Goles2) {
        $this->_Goles2 = $Goles2;
    }

}
