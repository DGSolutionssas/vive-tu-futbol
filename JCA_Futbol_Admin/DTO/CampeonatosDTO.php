<?php

/**
 * Clase DTO Campeonato
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
class CampeonatosDTO {

    private $_idCampeonato = null;
    private $_Campeonato = null;
    private $_descripcion = null;
    private $_grupos = null;
    private $_equipos = null;
    private $_cantidadJugadores = null;

    public function getIdCampeonato() {
        return $this->_idCampeonato;
    }

    public function setIdCampeonato($idCampeonato) {
        $this->_idCampeonato = $idCampeonato;
    }

    public function getCampeonato() {
        return $this->_Campeonato;
    }

    public function setCampeonato($campeonato) {
        $this->_Campeonato = $campeonato;
    }

    public function getDescripcion() {
        return $this->_descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->_descripcion = $descripcion;
    }

    public function getGrupos() {
        return $this->_grupos;
    }

    public function setGrupos($grupos) {
        $this->_grupos = $grupos;
    }

    public function getEquipos() {
        return $this->_equipos;
    }

    public function setEquipos($equipos) {
        $this->_equipos = $equipos;
    }

    public function getCantidadJugadores() {
        return $this->_cantidadJugadores;
    }

    public function setCantidadJugadores($cantidadJugadores) {
        $this->_cantidadJugadores = $cantidadJugadores;
    }

}
