<?php

/*
 * Classe que realiza a chamada da persistencia de acordo com a necessidade
 */

class Persistencia {

    private static $tipoPersistencia = 'BD';
    private $persistencia;

    public function __construct() {
        if (self::$tipoPersistencia === 'CSV') {
            $_SESSION['tipoPersistencia'] = 'CSV';
            $this->errorlog('P Iniciou a fabricação da peristência: PersistenciaCSV');
            $this->persistencia = $this->fabricaPersistencia('PersistenciaCSV');
            $this->errorlog('P Finalizou a fabricação da peristência: PersistenciaCSV');
        } else {
            $_SESSION['tipoPersistencia'] = 'BD';
            $this->errorlog('P Iniciou a fabricação da peristência: PersistenciaBD');
            $this->persistencia = $this->fabricaPersistencia('PersistenciaBD');
            $this->errorlog('P Finalizou a fabricação da peristência: PersistenciaBD');
        }
    }

    private function fabricaPersistencia($sNomeClasse) {
        return new $sNomeClasse();
    }

    public static function defineTipoPersistencia($tipo) {
        self::$tipoPersistencia = $tipo;
    }

    public function __call($method, $args) {
        $this->errorlog('P Chegou no método: __call($method, $args)');
        if (method_exists($this->persistencia, $method)) {
            return call_user_func_array([$this->persistencia, $method], $args);
        } else {
            $this->errorlog('P Método $method não encontrado na persistência atual.');
            throw new BadMethodCallException("Método $method não encontrado na persistência atual.");
        }
    }
    
    public function getTipoPersistencia(){
        return self::$tipoPersistencia;
    }
    
    public function errorlog($message) {
        // Abre o arquivo no modo de adição ('a')
        $fp = fopen('data/errorLog.txt', "a");

        // Adiciona uma nova linha ao arquivo com a data e hora atuais
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = $timestamp . ' - ' . $message . PHP_EOL;

        // Escreve no arquivo aberto
        fwrite($fp, $logEntry);

        // Fecha o arquivo
        fclose($fp);
    }
    
}
