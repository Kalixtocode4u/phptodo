<?php

class BD{

    private $conexao;

    public function __construct(){
    }

    /*public static function conexaoMySQL($db_server, $db_user, $db_pass, $db_name){
        $this->conexao = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }*/

    public function conexaoSQLite($caminho){
        $this->conexao = new SQLite3($caminho);
    }

    public function getConexao(){
        return $this->conexao;
    }
}