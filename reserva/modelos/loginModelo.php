<?php

class loginModelo extends Modelo {

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Metodo para iniciar sesion
     */
    public function login($rol, $email, $clave) {
        return $this->_bd->getFila('SELECT * FROM ' . $rol . ' WHERE email = ? AND clave = ?', array($email, md5($clave)));
    }
}
