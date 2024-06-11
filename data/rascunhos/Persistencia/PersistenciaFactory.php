<?php

class PersistenciaFactory {

    public static function createPersistencia($tipo) {
        if ($tipo === 'csv') {
            return new PersistenciaCSV();
        } elseif ($tipo === 'db') {
            return new PersistenciaDB();
        } else {
            throw new Exception('Tipo de persistência desconhecido');
        }
    }
}

?>