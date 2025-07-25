<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Planilha{
    private Spreadsheet $planilha;
    //private string $nomeplanilha = "";
    private static int $tamanho = 0;

    // Construtores
    public static function semArquivo(){
        $instancia = new Planilha();
        $instancia->iniciar();
        return $instancia;
    }
    public static function comArquivo(string $path){
        $instancia = new Planilha();
        $instancia->carregaPlanilha($path);
        
        $tam = $instancia->tamanhoPlanilha();
        $instancia->setTamanho($tam);
        return $instancia;
    }
    private function iniciar(){
        $this->planilha = new Spreadsheet();
        $folha = $this->planilha->getActiveSheet();
        // Adicionando informação as celulas
        $folha->setCellValue("A1", "Nome");
        $folha->setCellValue("B1", "Descricao");
        $folha->setCellValue("C1", "Prioridade");
        $folha->setCellValue("D1", "Prazo");
        $folha->setCellValue("E1", "Concluido");

        // Adicionando estilo as celulas
        $folha->getStyle("A1")->getFont()->setBold(true);
        $folha->getStyle("B1")->getFont()->setBold(true);
        $folha->getStyle("C1")->getFont()->setBold(true);
        $folha->getStyle("D1")->getFont()->setBold(true);
        $folha->getStyle("E1")->getFont()->setBold(true);

        // Aumenta o tamanho da linhas
        $this::$tamanho++;
    }

    // getters e setters
    private function setTamanho(int $tamanho){
        $this::$tamanho = $tamanho;
    }

    // Metodos

    public function setLinha(string $nome, string $descricao, string $prioridade, string $prazo, string $concluido) {
        $i = $this::$tamanho + 1;
        
        $folha = $this->planilha->getActiveSheet();
        $folha->setCellValue("A{$i}", $nome);
        $folha->setCellValue("B{$i}", $descricao);
        $folha->setCellValue("C{$i}", $prioridade);
        $folha->setCellValue("D{$i}", $prazo);
        $folha->setCellValue("E{$i}", $concluido);
        
        $this::$tamanho++;
    }

    public function lerPlanilha(){
        $folha = $this->planilha->getActiveSheet();
        $data = $folha->toArray();

        foreach ($data as $row){

            if (count(array_filter($row, function ($value) {
                return $value !== null;
            })) === 0) {
                break;    // Stop at the first empty row
            }

            foreach ($row as $cell){
                echo $cell . "\t";
            }
            echo "\n";
        }
    }
    
    public function salvaPlanilha(string $nome) {
        $xlsxSalvo = new Xlsx($this->planilha);
        $xlsxSalvo->save("{$nome}.xlsx");
    }

    // Metodos privados
    private function tamanhoPlanilha() : int{
        $i = 0;

        $folha = $this->planilha->getActiveSheet();
        $data = $folha->toArray();

        foreach ($data as $row){
            if (count(array_filter($row, fn($valor) => $valor !== null)) === 0) {
                break;
            }
            $i++;
        }

        return $i;

    }

    private function carregaPlanilha(string $caminho){
        $this->planilha = IOFactory::load($caminho);
    }

    
}