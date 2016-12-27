<?php

/**
 * Realizar la desconexion de la Sesion
 * @author Diego Saavedra
 * @created 25/12/2016
 * @copyright DG Solutions sas
 */
session_start();
session_destroy();
header('location: Index.html');
