<?php
require "classes/tarefas.php";
require "classes/bd.php";
//$titulo = "Olá, Mundo!\nMeu nome é Carlos✋😉⭐";

$sqlite = new BD();
$sqlite->conexaoSQLite("dev.db");

$classe = new Tarefas($sqlite->getConexao());

if(isset($_GET["submit"])){
    $nome = $_GET["nome"];
    $descricao = $_GET["descricao"];
    $prioridade = $_GET["prioridade"];
    $prazo = $_GET["prazo"];
    $concluido = isset($_GET["concluido"])? "sim": "não";

    $classe->inserir_tarefa($nome, $descricao, $prazo, $prioridade, $concluido);

    header("location: index.php");
    die();
}


$listadeTarefa = $classe->buscar_tarefas();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="cabesalho">
        <h1>App Todo</h1>
    </header>
    <main class="conteudo">
        <div class="conteiner">
            <form>
                <fieldset>
                    <legend>Defina uma tarefa</legend>
                    <label>
                        Nome:
                        <input type="text" name="nome" id="">
                    </label>
                    
                    <fieldset>
                        <legend>Descrição:</legend>
                        <textarea name="descricao" id="" cols="30" rows="10"></textarea>
                    </fieldset>

                    <fieldset>
                        <legend>Prioridade</legend>
                        <label>
                            Alta
                            <input type="radio" name="prioridade" value="Alta">
                            Media
                            <input type="radio" name="prioridade" value="Media">
                            Baixa
                            <input type="radio" name="prioridade" value="Baixa">
                        </label>
                    </fieldset>

                    <label>
                        Prazo:
                        <input type="date" name="prazo">
                    </label>
                    <br>
                    <label>
                        concluido:
                        <input type="checkbox" name="concluido">
                    </label>
                    <br>
                    <button type="submit" name="submit">Enviar</button>
                </fieldset>
            </form>
        </div>
        <div class="lista">
            <h3>lista de tarefa</h3>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Prioridade</th>
                        <th>Prazo</th>
                        <th>Concluida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($listadeTarefa as $key => $tarefa) {
                    ?>
                    <tr>
                    <?php
                        foreach ($tarefa as $key2 => $t){
                    ?>
                        <td><?= $t?></td>
                    <?php 
                        }?>
                    </tr>
                    <?php
                    } ?>
                </tbody>
            </table>
            <div class="botoes">
                <form action="exportar.php">
                    <button type="submit" >Exportar para Excel</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>