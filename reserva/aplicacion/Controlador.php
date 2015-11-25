<?php

/**
 * Archivo 'Controlador'
 * 
 * En este archivo se declara la clase 'Controlador', del cual extenderan los
 * otros controllers.
 * 
 * @license http://creativecommons.org/licenses/by-sa/2.5/pe/ Atribucion-CompartirIgual 2.5 Peru
 */

/**
 * Clase 'Controlador' del cual iran extendiendo los demas controladores
 * 
 * Esta clase es la clase padre de todos los controladores por ejemplo: indexControlador.
 * Tiene un metodo abstacto index, que sera heredado obligatoriamente para sus hijos.
 */
abstract class Controlador {

    /** @var Vista */
    protected $_vista;

    /** @var $_POST* */
    protected $post;

    public function __construct() {
        $this->_vista = new Vista(new Peticion());
        $this->post = filter_input_array(INPUT_POST);
    }

    /**
     * Método principal del controlador
     */
    abstract public function index();

    /**
     * Metodo que retorna la  instancia de un modelo 
     * @param type $modelo
     * @return modelo
     * @throws Exception modelo no encontrado
     */
    protected function getModelo($modelo) {
        $modelo = $modelo . 'Modelo';
        $rutaModelo = RAIZ . 'modelos' . SD . $modelo . '.php';

        if (is_readable($rutaModelo)) {
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        }
        throw new Exception('Error modelo no encontrado');
    }

    /**
     * Metodo qie incluye una libreria ubicada en la carpeta librerias
     * @param strting nombre de la libreria
     * @throws Exception libreria no encontrada
     */
    protected function getLibreria($libreria) {
        $rutaLibreria = RAIZ . 'librerias' . SD . $libreria . '.php';
        if (is_readable($rutaLibreria)) {
            require_once $rutaLibreria;
        } else {
            throw new Exception('Error libreria no encontrada');
        }
    }

    /**
     * Metodo que Redirecciona a una url 
     * @param type $ruta
     */
    public function redireccionar($ruta = FALSE, $hash = '') {
        if ($ruta) {
            header('location: ' . URL_BASE . $ruta . $hash);
            exit(0);
        }
        header('location: ' . URL_BASE . $hash);
        exit(0);
    }

    /**
     * Metodo que convierte a enteros
     * @param type $int
     * @return int
     */
    protected function aInt($int) {
        $_aux = filter_var($int, FILTER_VALIDATE_INT);
        if (is_int($_aux)) {
            return $_aux;
        }
        return FALSE;
    }

    /**
     * Metodo que valida un entero enviado por post
     * @param string $clave
     * @return int
     */
    protected function getInt($clave) {
        if (!is_null($this->post[$clave])) {
            $_aux = filter_var($this->post[$clave], FILTER_VALIDATE_INT);
            if ($_aux) {
                $this->post[$clave] = $_aux;
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Método que valida un texto enviado por post
     * @param type $clave
     * @return string
     */
    protected function getTex($clave) {
        if (!is_null($this->post[$clave])) {
            $this->post[$clave] = trim($this->post[$clave]);
            if (strlen($this->post[$clave]) > 0) {
                $this->post[$clave] = htmlspecialchars($this->post[$clave], ENT_NOQUOTES);
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Método que valida un campo alfanumerico enviado por post
     * @param type $clave
     * @param type $min minimo de caracteres
     * @param type $max máximo de caracteres
     * @return boolean
     */
    protected function getAlpNum($clave, $min, $max) {
        if (!is_null($this->post[$clave])) {
            if (preg_match('/^[a-zA-Z0-9_\-]{' . $min . ',' . $max . '}$/', $this->post[$clave])) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Metodo que valida un campo de texto alternativo enviado por post
     * @param type $clave
     * @return null
     */
    protected function getAltTex($clave) {
        if (!is_null($this->post[$clave])) {
            $_aux = trim($this->post[$clave]);
            if (!empty($_aux)) {
                $this->post[$clave] = htmlspecialchars($_aux, ENT_NOQUOTES);
                return TRUE;
            }
        }
        $this->post[$clave] = NULL;
        return TRUE;
    }

    /**
     * Metodo que valida un campo email enviado por post
     * @param string campo
     * @return false si es inavlido, la cadena si es correcta
     */
    protected function getEmail($clave) {
        if (!is_null($this->post[$clave])) {
            $_aux = filter_var($this->post[$clave], FILTER_VALIDATE_EMAIL);
            if ($_aux) {
                $this->post[$clave] = $_aux;
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Método que encripta una cadena
     * @param type $pass
     * @return type
     */
    protected function getHash($pass) {
        $hash = hash_init('md5', HASH_HMAC, HASH_KEY);
        hash_update($hash, $pass);
        return hash_final($hash);
    }

    /**
     * Método que valida un campo password enviado por post
     * @param type $clave
     * @return boolean
     */
    protected function getPas($clave) {
        if (!is_null($this->post[$clave])) {
            if (preg_match('/^.{6,}$/', $this->post[$clave])) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Método que imprime deatelles de una variable
     * @param variable $var
     */
    protected function dump($var) {
        echo var_dump($var);
    }

    /**
     * Método que valida un valor numerico enviado por post
     * @param type $clave
     * @param int $tam numero de digitos
     * @return boolean
     */
    protected function getNum($clave, $tam) {
        if (!is_null($this->post[$clave])) {
            if (preg_match('/^[0-9]{' . $tam . '}$/', $this->post[$clave])) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Método que valida un valor numerico alternativo enviado por post
     * @param type $clave
     * @return type
     */
    protected function getAltNum($clave) {
        if (!is_null($this->post[$clave])) {
            if (preg_match('/^[0-9]+$/', $this->post[$clave])) {
                return TRUE;
            }
        }
        $this->post[$clave] = NULL;
        return TRUE;
    }

    /**
     * Método que elimina valores de la variable post
     * @param type $clave nobmbre de la variable
     * @throws Exception si no existe la variable
     */
    protected function quitar($clave) {
        if (is_array($clave)) {
            for ($i = 0; $i < count($clave); $i++) {
                if (!isset($this->post[$clave[$i]])) {
                    throw new Exception('No existe variable en post');
                }
                unset($this->post[$clave[$i]]);
            }
        } else {
            if (!isset($this->post[$clave])) {
                throw new Exception('No existe variable en post');
            }
            unset($this->post[$clave]);
        }
    }

    /**
     * Método que retorna solo valores de la variable post
     * @return type
     */
    protected function getPost() {
        return array_values($this->post);
    }

    /**
     * Método que agrega un valor al final de la variable post
     * @param type $clave
     * @param type $valor
     */
    protected function setPost($clave, $valor) {
        $this->post[$clave] = $valor;
    }

    /**
     * Método que valida una fecha 
     * @param type $clave campo
     * @param type $dia
     * @param type $mes
     * @param type $anio
     * @return bool 
     */
    protected function esFecha($clave, $dia, $mes, $anio) {
        $this->post[$clave] = $anio . '-' . $mes . '-' . $dia;
        return checkdate($mes, $dia, $anio);
    }

    /**
     * Método que parte una fecha yyyy-mm-dd
     * @param type $fecha
     * @return boolean|array
     */
    protected function partirFecha($fecha) {
        $partes = array();
        if (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/', $fecha, $partes)) {
            return array('dia' => $partes[3], 'mes' => $partes[2], 'anio' => $partes[1]);
        }
        return FALSE;
    }

    /**
     * Convierte fecha dd-mm-yyyy a yyyy-mm-dd
     * @param type $fecha
     * @return int
     */
    protected function fechaMysql($fecha) {
        $fecha = explode('-', $fecha);
        return $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];
    }

    /**
     * Método que genera una clave
     * @return string
     */
    protected function generarClave() {
        $cad = 'qMweSrItByuDUiopYNaFsdTfgGhjkHCAlzXxcvbJPRKVnm1E2L34WZ56789';
        $pas = '';
        while (strlen($pas) < 6) {
            $pas = $pas . $cad[rand(0, strlen($cad) - 1)];
        }
        return $pas;
    }

    /**
     * Método que valida una hora en formato 24 horas
     * @param string $clave
     * @return boolean
     */
    protected function getHora($clave) {
        if (!is_null($this->post[$clave])) {
            if (preg_match('/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/', $this->post[$clave])) {
                return TRUE;
            }
        }
        return FALSE;
    }

    protected function getDecimal($clave) {
        if (!is_null($this->post[$clave])) {
            if (preg_match('/^([0-9]+|[0-9]+\.[0-9]+)$/', $this->post[$clave])) {
                return TRUE;
            }
        }
        return FALSE;
    }

}
