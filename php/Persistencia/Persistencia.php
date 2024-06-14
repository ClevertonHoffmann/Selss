<?php

/*
 * Classe que realiza a chamada da persistencia de acordo com a necessidade
 */

class Persistencia {

    private static $tipoPersistencia = 'CSV';
    private $persistencia;

    public function __construct() {
        if (self::$tipoPersistencia === 'CSV') {
            $this->persistencia = $this->fabricaPersistencia('PersistenciaCSV');
        } else {
            $this->persistencia = $this->fabricaPersistencia('PersistenciaBD');
        }
    }

    private function fabricaPersistencia($sNomeClasse) {
        return new $sNomeClasse();
    }

    public static function defineTipoPersistencia($tipo) {
        self::$tipoPersistencia = $tipo;
    }

    public function __call($method, $args) {
        if (method_exists($this->persistencia, $method)) {
            return call_user_func_array([$this->persistencia, $method], $args);
        } else {
            throw new BadMethodCallException("Método $method não encontrado na persistência atual.");
        }
    }
}
