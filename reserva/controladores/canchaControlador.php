<?php

class canchaControlador extends Controlador {

    /** @var canchaModelo  */
    private $_modelo;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
    }

    public function nuevo() {
        if ($this->getInt('guardar')) {
            $this->_vista->dato = $this->post;
            $this->_modelo = $this->getModelo('cancha');
            if (!$this->getTex('nombre')) {
                $this->_vista->error[] = 'Nombre no válido.';
            }
            if (!$this->getTex('ubicacion')) {
                $this->_vista->error[] = 'Ubicacion  no válido.';
            } elseif ($this->_modelo->existeUbicacion($this->post['ubicacion'])) {
                $this->_vista->error[] = 'Ubicacion ya existe.';
            }
            if (!isset($this->_vista->error)) {
                $this->quitar('guardar');
                $this->setPost('admin_id', Sesion::get('id'));
                $this->_modelo->insertar($this->getPost());
                Sesion::set('_msg', 'Se ha insertado un cancha');
                $this->redireccionar('cancha/listar');
            }
        }
        $this->_vista->titulo = 'Nuevo cancha';
        $this->_vista->renderizar('nuevo');
    }
    public function listar() {
        $this->_modelo = $this->getModelo('cancha');
        $this->_vista->dato = $this->_modelo->listar();
        $this->_vista->titulo = 'Lista de cancha';
        $this->_vista->renderizar('listar');
        $this->_vista->setJs('cancha');
        $this->_vista->renderizar('listar');
    }
    public function calificar($id) {
        $id = $this->aInt($id);
        if (!$id) {
            $this->redireccionar('cancha/listar');
        }
        print($id);
        if ($this->getInt('guardar')) {
            $this->_vista->dato = $this->post;
            $this->_modelo = $this->getModelo('cancha');
            $a = $this->_modelo->existeCancha($id);
            $c = $this->_modelo->existeCalificacion($id);
            if ($this->post['calificacion'] == 1) {
                $cal = ($c + 1)/2;
            } elseif ($this->post['calificacion'] == 2) {
                $cal = ($c + 2)/2;
            } elseif ($this->post['calificacion'] == 3) {
                $cal = ($c + 3)/2;
            } elseif ($this->post['calificacion'] == 4) {
                $cal = ($c + 4)/2;
            } elseif ($this->post['calificacion'] == 5) {
                $cal = ($c + 5)/2;
            }            
            if (!isset($this->_vista->error)) {
                $this->quitar('guardar');
                $this->setPost('calificacion', $cal);
                $this->setPost('id', ($a));
                $this->_modelo->calificar($this->getPost());
                Sesion::set('_msg', 'Se ha calificado la cancha');
                $this->redireccionar('cancha/listarCancha');
            }
        }
        $this->_vista->titulo = 'Calificar Cancha';
        $this->_vista->renderizar('calificar');
    }
    public function listarCancha() {
        $this->_modelo = $this->getModelo('cancha');
        $this->_vista->dato = $this->_modelo->listarCancha();
        $this->_vista->titulo = 'Lista de cancha';
        $this->_vista->renderizar('listarCan');
        $this->_vista->setJs('cancha');
        $this->_vista->renderizar('listarCan');
    }
    public function editar($id) {
        $id = $this->aInt($id);
        if (!$id) {
            $this->redireccionar('cancha/listar');
        }
        $this->_modelo = $this->getModelo('cancha');
        $this->_vista->dato = $this->_modelo->get($id);
        if (!$this->_vista->dato) {
            $this->redireccionar('cancha/listar');
        }
        if ($this->getInt('guardar')) {
            $this->_vista->dato = $this->post;
            if (!$this->getTex('nombre')) {
                $this->_vista->error[] = 'Nombre no válido.';
            }
            if (!$this->getTex('ubicacion')) {
                $this->_vista->error[] = 'Ubicacion  no válido.';
            } elseif ($this->_modelo->existeUbicacion($this->post['ubicacion'])) {
                $this->_vista->error[] = 'Ubicacion ya existe.';
            }
            if (!isset($this->_vista->error)) {
                $this->quitar('guardar');
                $this->setPost('id', $id);
                $this->_modelo->editar($this->getPost());
                Sesion::set('_msg', 'Se ha guardado su operación');
                $this->redireccionar('cancha/listar');
            }
        }
        $this->_vista->titulo = 'Editar cancha';
        $this->_vista->renderizar('nuevo');
    }

    public function eliminar($id) {
        $id = $this->aInt($id);
        if (!$id) {
            $this->redireccionar('cancha/listar');
        }
        $this->_modelo = $this->getModelo('cancha');
        $this->_vista->dato = $this->_modelo->get($id);
        if (!$this->_vista->dato) {
            $this->redireccionar('cancha/listar');
        }
        if ($this->getInt('guardar')) {
            $this->_modelo->eliminar($id);
            Sesion::set('_msg', 'Se ha eleiminado un cancha');
            $this->redireccionar('cancha/listar');
        }
        $this->_vista->titulo = '¿Desea eliminar el cancha ' . $this->_vista->dato['nombre'] . '?';
        $this->_vista->renderizar('eliminar');
    }
    
        public function buscar_cancha($nobre) {
        $this->_modelo = $this->getModelo('cancha');
        $this->_vista->dato = $this->_modelo->buscarCancha($nombre);
        $this->_vista->renderizar('buscar', TRUE);

    }

}