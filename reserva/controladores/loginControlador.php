<?php

class loginControlador extends Controlador {

    /** @var loginModelo  */
    private $_modelo;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($this->getInt('guardar')) {
            $this->dump($this->post);
            $this->_vista->dato = $this->post;
            if ($this->post['rol'] == 'usu') {
                $_rol = 'usuario';
            } elseif ($this->post['rol'] == 'admin') {
                $_rol = 'administrador';
            } elseif ($this->post['rol'] == 'cont') {
                $_rol = 'control';
            }
            $this->_modelo = $this->getModelo('login');
            $usua = $this->_modelo->login($_rol, $this->post['email'], $this->post['clave']);
            if ($usua) {
                Sesion::set('iniciado', TRUE);
                Sesion::set('nombre', $usua['nombre']);
                Sesion::set('id', $usua['id']);
                Sesion::set('rol', $this->post['rol']);
                $this->redireccionar();
            }
            $this->_vista->error[] = 'No pudo acceder al sistema, revise sus datos.';
        }
        $this->_vista->titulo = 'Acceder al sistema';
        $this->_vista->renderizar('login');
    }

    public function salir() {
        Sesion::matar();
        $this->redireccionar();
    }

}
