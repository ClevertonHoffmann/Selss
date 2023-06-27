<?php

/*
 * Classe reponsável por gerar a estrutura visualização das modais
 */

class ViewModal {

    /**
     * Recebe como parâmetro o array que veio do csv
     * @return string
     */
    public function geraModalTabelaLexica($aCsvArray) {

        $sHtmlModal = '<div class="modal-content">
                <div class="modal-header">
                    <h2>Tabela de Analise Léxica</h2>
                    <span class="modal-close" onclick="closeModal()">&times;</span>
                </div>'
                . '<div id="csvData">'
                . '<table>';
        foreach ($aCsvArray as $row) {
            $sHtmlModal .= '<tr>';
            foreach ($row as $cell) {
                $sHtmlModal .= '<td>' . htmlspecialchars($cell) . '</td>';
            }
            $sHtmlModal .= '</tr>';
        }
        $sHtmlModal .= '</table>'
                . '</div>';

        return $sHtmlModal;
    }

}

//        <div id="myModal" class="modal">
//        </div>