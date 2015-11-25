<?php

class reservaModelo extends Modelo {

    public function __construct() {
        parent::__construct();
    }

    public function insertar($cancha_id, $usuario_id, $fecha, $hora) {
        $this->_bd->ejecutar('INSERT INTO reserva VALUES(NULL, ?, ?, ?, ?, NOW(), 0, 0, NULL, NULL)', array($cancha_id, $usuario_id, $fecha, $hora));
    }

    public function horas_ocupadas($cancha, $fecha) {
        return $this->_bd->getArray('SELECT * FROM reserva WHERE cancha_id =? AND fecha = ?', array($cancha, $fecha));
    }

    public function contar($usuario_id) {
        return $this->_bd->getScalar('SELECT COUNT(id) FROM reserva WHERE usuario_id=?', array($usuario_id));
    }

    public function listar($usuario_id, $pagina) {
        $pagina = ($pagina - 1) * REG_PAG;
        return $this->_bd->getArray('SELECT reserva.*, cancha.nombre FROM reserva INNER JOIN cancha ON reserva.cancha_id=cancha.id WHERE reserva.usuario_id = ? ORDER BY reserva.id LIMIT ' . $pagina . ',' . REG_PAG, array($usuario_id));
    }
    public function listarMio($usuario_id, $pagina) {
        $pagina = ($pagina - 1) * REG_PAG;
        return $this->_bd->getArray('SELECT reserva.*, cancha.nombre FROM reserva INNER JOIN cancha ON reserva.cancha_id=cancha.id and cancha.admin_id = ? ORDER BY reserva.id LIMIT ' . $pagina . ',' . REG_PAG, array(Sesion::get('id')));
    }
    public function eliminar($id) {
        $this->_bd->ejecutar('DELETE FROM reserva WHERE id = ?', $id);
    }
    public function get($id) {
        return $this->_bd->getFila('SELECT * FROM reserva WHERE id = ?', $id);
    }

}
