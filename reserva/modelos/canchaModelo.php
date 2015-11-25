<?php

class canchaModelo extends Modelo {
    public function __construct() {
        parent::__construct();
    }
    
    public function insertar($datos) {
        $this->_bd->ejecutar('INSERT INTO cancha VALUES(NULL, ?, ?, ?, NULL)', $datos);
    }
    
    public function contar() {
        return $this->_bd->getScalar('SELECT COUNT(id) FROM cancha');
    }
        
    public function get($id) {
        return $this->_bd->getFila('SELECT * FROM cancha WHERE id = ?', $id);
    }
    public function listar() {
        return $this->_bd->getArray('SELECT * FROM cancha WHERE admin_id = ?', array(Sesion::get('id')));
    }
    public function listarCancha() {
        return $this->_bd->getArray('SELECT * FROM cancha');
    }
    public function existeUbicacion($ubicacion) {
        return $this->_bd->getScalar('SELECT id FROM cancha WHERE ubicacion = ?', $ubicacion);
    }
    public function editar($datos) {
        $this->_bd->ejecutar('UPDATE cancha SET nombre=?, ubicacion=? WHERE id = ?', $datos);
    }
    public function existeCancha($id) {
        return $this->_bd->getScalar('SELECT cancha.id FROM cancha INNER JOIN reserva ON reserva.cancha_id=cancha.id and reserva.id = ?', $id);
    }
    public function existeCalificacion($id) {
        return $this->_bd->getScalar('SELECT calificacion FROM cancha INNER JOIN reserva ON reserva.cancha_id=cancha.id and reserva.id = ?', $id);
    }
    
    public function calificar($datos) {
        $this->_bd->ejecutar('UPDATE bdrc.cancha SET calificacion = ? WHERE cancha.id = ?', $datos);
        
    }

    public function eliminar($id) {
        $this->_bd->ejecutar('DELETE FROM cancha WHERE id = ?', $id);
    }

    public function buscarPlaca($nombre) {
        return $this->_bd->getArray('SELECT * FROM cancha WHERE nombre LIKE ?', $nombre . '%');
    }

   
}
