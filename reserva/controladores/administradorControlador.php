<?php

class administradorControlador extends Controlador {

    /** @var administradorModelo  */
    private $_modelo;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
    }

    public function nuevo() {
        if ($this->getInt('guardar')) {
            $this->_vista->dato = $this->post;
            $this->_modelo = $this->getModelo('administrador');
            if (!$this->getTex('nombre')) {
                $this->_vista->error[] = 'Nombre no válido.';
            }
            if (!$this->getNum('dni', 8)) {
                $this->_vista->error[] = 'DNI no válido.';
            } elseif ($this->_modelo->existeDni($this->post['dni'])) {
                $this->_vista->error[] = 'DNI ya existe.';
            }            
            $this->getAltNum('telefono');
            
            if (!$this->getTex('direccion')) {
                $this->_vista->error[] = 'Dirección no válido.';
            }
            if (!$this->getEmail('email')) {
                $this->_vista->error[] = 'Email no válido.';
            } elseif ($this->_modelo->existeEmail($this->post['email'])) {
                $this->_vista->error[] = 'Email ya existe.';
            }
            if (!$this->getPas('clave')) {
                $this->_vista->error[] = 'Clave no valido, minimo 6 caracteres.';
            } elseif ($this->post['clave'] != $this->post['reclave']) {
                $this->_vista->error[] = 'Las claves no coinciden.';
            }
            if (!isset($this->_vista->error)) {
                $this->quitar(array('guardar', 'reclave'));
                $this->post['clave'] = md5($this->post['clave']);
                $this->_modelo->insertar($this->getPost());
                Sesion::set('_msg', 'Se ha creado su cuenta de  administrador');
            }
        }
        $this->getLibreria('funciones');
        $this->_vista->titulo = 'Nuevo administrador';
        $this->_vista->renderizar('nuevo');
    }

    

}
