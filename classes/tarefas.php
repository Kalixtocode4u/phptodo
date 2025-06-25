<?php

//require "classes/bd.php";

//session_start();

class Tarefas{
    public SQLite3 $conexao;

    //public $tarefas = [];

    public function __construct(SQLite3 $conexao){
        $this->conexao = $conexao;
    }

    public function criar_tabela_tarefas_se_nao_existir(){
        if($this->conexao->exec('CREATE TABLE IF NOT EXISTS tarefas (id INTEGER PRIMARY KEY autoincrement, nome VARCHAR(25),descricao VARCHAR ,prazo VARCHAR ,prioridade VARCHAR ,concluido VARCHAR);')){
            echo "Tabela tarefas criada com sucesso\n";
        }else{
            echo "Falha em criar a tabela\n";
        }
    }

    public function buscar_tarefas(){
        $consulta = "SELECT * FROM tarefas";
        $resultado = $this->conexao->query($consulta);

        $data = [];

        while($tarefas = $resultado->fetchArray(SQLITE3_ASSOC)){
            array_push($data, $tarefas);
        }

        return $data;
    }
    public function buscar_tarefa_com_id($id){
        $consulta = "SELECT * FROM tarefas WHERE id={$id}";
        $resultado = $this->conexao->query($consulta);
        return $resultado;
    }

    public function inserir_tarefa($nome, $descricao, $prioridade, $prazo, $concluido){
        $stmt = $this->conexao->prepare("INSERT INTO tarefas(id, nome, descricao, prioridade, prazo, concluido) VALUES (NULL, :n, :d, :p, :z, :c);");
        
        $stmt->bindValue(':n', $nome);
        $stmt->bindValue(':d', $descricao);
        $stmt->bindValue(':p', $prioridade);
        $stmt->bindValue(':z', $prazo);
        $stmt->bindValue(':c', $concluido);
        
        if($stmt->execute()){
            echo "tarefa inserida";
        }else{
            echo "falha em inserir a tarefa";
        }
    }

    public function editar_tarefa($id, $nome, $descricao, $prioridade, $prazo, $concluido){
        $update = "UPDATE tarefas SET nome = {$nome}, descricao = {$descricao}, prioridade = {$prioridade}, prazo = {$prazo}, concluido = {$concluido} WHERE id={$id}";
        $resultado = $this->conexao->exec($update);
        return $resultado;
    }

    public function remover_tarefa($id){
        $delete = "DELETE FROM tarefas WHERE id={$id}";
        $resultado = $this->conexao->exec($delete);
        return $resultado;
    }
}

/*function buscarTarefa(){
    if(isset($_GET["nome"])){
        $tarefa = [];
        
        
        $tarefa["nome"] = $_GET["nome"];
    
        if(isset($_GET["descricao"])){
            $tarefa["descricao"] = $_GET["descricao"];
        }
    
        if(isset($_GET["prioridade"])){
            $tarefa["prioridade"] = $_GET["prioridade"];
        }else{
            $tarefa["prioridade"] = "";
        }
        
        if(isset($_GET["prazo"])){
            $tarefa["prazo"] = $_GET["prazo"];
        }else{
            $tarefa["prazo"] = "";
        }
        
        if(isset($_GET["concluido"])){
            $tarefa["concluido"] = $_GET["concluido"];
        }else{
            $tarefa["concluido"] = "";
        }
    
        $_SESSION["lista_tarefa"][] = $tarefa;
        header("location: index.php");
        die();
    }
}

if(isset($_SESSION["listaTarefa"])){
    $listadeTarefa = $_SESSION["lista_tarefa"];
}*/