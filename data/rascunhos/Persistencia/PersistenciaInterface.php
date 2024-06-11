<?php

interface PersistenciaInterface {
    public function gravaArrayEmCSV($sArquivo, $iTipo, $dadosArray);
    public function gravaArrayCompostoEmCSV($sArquivo, $iTipo, $dadosArray);
    public function retornaArrayCSV($sArquivo, $iTipo);
    public function retornaArrayCompostoCSV($sArquivo, $iTipo);
    public function gravaArquivo($sArquivo, $sText);
}

?>

// Exemplo de uso:
$tipoPersistencia = 'csv'; // ou 'db', dependendo da necessidade
$persistencia = PersistenciaFactory::createPersistencia($tipoPersistencia);

// Agora você pode usar a instância $persistencia sem precisar se preocupar se é CSV ou DB
$persistencia->gravaArrayEmCSV('arquivo.csv', 0, $dadosArray);