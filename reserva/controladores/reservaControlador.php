<?php

class reservaControlador extends Controlador {

    /** @var reservaModelo  */
    private $_modelo;

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function nueva($cancha = 0) {
        if ($this->getInt('guardar')) {
            $this->_vista->dato = $this->post;
            if (!$this->getTex('fecha')) {
                $this->_vista->error[] = 'Fecha no válido.';
            }
            if (!$this->getTex('hora')) {
                $this->_vista->error[] = 'Hora no válido.';
            }
            if (!isset($this->_vista->error)) {
                $this->_modelo = $this->getModelo('reserva');
                $this->_modelo->insertar($this->post['cancha_id'], Sesion::get('id'), $this->fechaMysql($this->post['fecha']), $this->post['hora']);
                Sesion::set('_msg', 'Se ha reservado su cancha');
                $this->redireccionar('reserva/listar');
            }
        }
        $this->_vista->setJs('reserva');
        $this->_vista->titulo = 'Nuevo reserva';
        $this->_vista->cancha_id = $cancha;
        $this->_vista->renderizar('nuevo');
    }

    public function listar($pagina = 1) {
        $this->_modelo = $this->getModelo('reserva');
        $this->_vista->getPaginacion($pagina, $this->_modelo->contar(Sesion::get('id')), 'reserva/listar/');
        $this->_vista->dato = $this->_modelo->listar(Sesion::get('id'), $this->_vista->pactual);
        $this->_vista->titulo = 'Lista de tus reservas';
        $this->_vista->renderizar('listar');
    }
    public function listarMio($pagina = 1) {
        $this->_modelo = $this->getModelo('reserva');
        $this->_vista->getPaginacion($pagina, $this->_modelo->contar(Sesion::get('id')), 'reserva/listar/');
        $this->_vista->dato = $this->_modelo->listarMio(Sesion::get('id'), $this->_vista->pactual);
        $this->_vista->titulo = 'Horario de reserva de cancha';
        $this->_vista->renderizar('listarMio');
    }

    public function ver_horas($cancha, $fecha) {
        //la fecha viene en dd-mm-yyyy lo volteamoa a yyyy-mm-dd
        $fecha = $this->fechaMysql($fecha);
        $actual = strtotime(date('Y-m-d'));
        $elegido = strtotime($fecha);
        $todos = array();

        if ($elegido < $actual) {
            echo 'Fecha no valida';
            exit(0);
        } elseif ($elegido == $actual) {
            $horaacutal = date('H');
            for ($i = $horaacutal + 1; $i < 24; $i++) {
                if ($i < 10) {
                    $todos[] = '0' . $i . ':00:00';
                } else {
                    $todos[] = $i . ':00:00';
                }
            }
        } else {
            for ($i = 0; $i < 24; $i++) {
                if ($i < 10) {
                    $todos[] = '0' . $i . ':00:00';
                } else {
                    $todos[] = $i . ':00:00';
                }
            }
        }
        $this->_modelo = $this->getModelo('reserva');
        $reservados = $this->_modelo->horas_ocupadas($cancha, $fecha);
        $ocupados = array();
        for ($i = 0; $i < count($reservados); $i++) {
            $ocupados[] = $reservados[$i]['hora'];
        }

        //quitamos las horas ocupadas de todas las horas
        $dispo = array_diff($todos, $ocupados);
        $this->_vista->dispo = $dispo;
        $this->_vista->renderizar('ver_horas', TRUE);
    }
    public function eliminar($id) {
        $id = $this->aInt($id);
        if (!$id) {
            $this->redireccionar('reserva/listar');
        }
        $this->_modelo = $this->getModelo('reserva');
        $this->_vista->dato = $this->_modelo->get($id);
        if (!$this->_vista->dato) {
            $this->redireccionar('reserva/listar');
        }
        if ($this->getInt('guardar')) {
            $this->_modelo->eliminar($id);
            Sesion::set('_msg', 'Se ha eleiminado un reservacion');
            $this->redireccionar('reserva/listar');
        }
        $this->_vista->titulo = '¿Desea eliminar la reservacion de la hora ' . $this->_vista->dato['hora'] . '?';
        $this->_vista->renderizar('eliminar');
    }

}
