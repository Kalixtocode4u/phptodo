<?php

// Definir a estrutura do mailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer{
    
    function enviar_email($tarefa, $anexos = []){
        $email = new PHPMailer();

        $email->isSMTP();
        $email->Host = "smtp.gmail.com";
        $email->Port = 587;
        $email->SMTPSecure = "tls";
        $email->SMTPAuth = true;
        $email->Username = "carlospedrox50@gmail.com";
        $email->Password = "minhasenha";
        $email->setFrom("meuemail@email.com","Avisador de tarefa");
        $email->addAddress("meuemail@dominio.com");
        $email->Subject = "Aviso de tarefa {$tarefa['nome']}";
        
        $corpo = $this->preparar_corpo_email($tarefa, $anexos);
        
        $email->msgHTML($corpo);

        foreach($anexos as $anexo){
            $email->addAttachment("anexos/{$anexo['email']}");
        }

        $email->send();
    }

    function preparar_corpo_email($tarefa, $anexos){
        ob_start();
        include "util/template_email.php";
        $corpo = ob_get_contents();
        ob_end_clean();

        return $corpo;
    }
}