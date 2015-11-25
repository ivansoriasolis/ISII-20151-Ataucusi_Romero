<?php

class usuarioModelo extends Modelo {
    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($datos) {
        $this->_bd->ejecutar('INSERT INTO usuario VALUES(NULL, ?, ?, ?, ?, ?, ?)', $datos);
    }
    
    public function existeDni($dni) {
        return $this->_bd->getScalar('SELECT id FROM usuario WHERE dni = ?', $dni);
    }
    
    public function existeEmail($email) {
        return $this->_bd->getScalar('SELECT id FROM usuario WHERE email = ?', $email);
    }
    
    public function contar() {
        return $this->_bd->getScalar('SELECT COUNT(id) FROM usuario');
    }
        
    public function get($id) {
        return $this->_bd->getFila('SELECT * FROM usuario WHERE id = ?', $id);
    }
    
   
}
