<?php
require "vendor/autoload.php";
require "classes/tarefas.php";
require "classes/bd.php";
require "classes/planilha.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <form>
            <label for="">
                Nome do arquivo:
                <input type="text" name="arquivo">
            </label>
            <br>
            <button type="submit" name="submit">Exportar</button>
        </form>
    </main>
</body>
</html>
<?php

if(isset($_GET["submit"]) && isset($_GET["arquivo"])){
    if(trim($_GET["arquivo"]) != ""){
        $nome_arquivo = $_GET["arquivo"];
        $bd = new BD();
        $bd->conexaoSQLite("dev.db");
        
        $classe = new Tarefas($bd->getConexao());
        
        $lista_tarefas = $classe->buscar_tarefas();
        
        $planilha = Planilha::semArquivo();
        
        foreach ($lista_tarefas as $tarefa => $t){
            $planilha->setLinha($t["nome"], $t["descricao"], $t["prioridade"], $t["prazo"], $t["concluido"]);
        }
        
        $planilha->salvaPlanilha($nome_arquivo);
        
        header("location: index.php");
        die();
    }
    header("location: exportar.php");
    die();
}

?>