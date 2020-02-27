<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require app_path().'/start/constants.php';
use Session;

class ControladorEsenciasContacto extends Controller{
    public function index(){
        $titulo = "CONTACTO";
        return view('esencias.contacto', compact('titulo'));
    
    }
    public function enviar(Request $request){
        $titulo = "Enviado";        
    //     $email =  $request->input('txtEmail');
    //     $nombre =  $request->input('txtNombre');
    //     $replyTo = $request->input('no-reply@gmail.com');

        
    //      //Instancia y configuraciones de PHPMailer

    //     $mail = new PHPMailer(true);
    //     $mail->SMTPDebug = 0;
    //     $mail->isSMTP();
    //     $mail->Host = env('MAIL_HOST');
    //     $mail->SMTPAuth = true;
    //     $mail->Username = env('MAIL_USERNAME');
    //     $mail->Password = env('MAIL_PASSWORD');
    //     $mail->SMTPSecure = env('MAIL_ENCRYPTION');
    //     $mail->Port = env('MAIL_PORT');

    //     //Destinatarios
    //     $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')); //Dirección desde
    //     $mail->addAddress($email); //Dirección para
    //     $mail->addReplyTo($replyTo); //Dirección de reply to
    //     $mail->AddBCC("admin@admin.com","Nombre copia 1"); // copia oculta


    //     //Contenido del mail

    //     $mail->isHTML(true);
    //     $mail->Subject = "Formulario de contacto";
    //     $mail->Body = "Gracias por contactarte, te responderemos a la brevedad";
    //     //$mail->send();

    //     $mail->ClearAllRecipients( );
    //     $mail->addAddress("admin@admin.com"); //Dirección para

    //     $mail->Subject = "Contacto desde la web";
    //     $mail->Body = "Recibiste un contacto desde la web:
    //     Nombre:" . $nombre ;
    //    // $mail->send();

        return view('esencias.contactoEnviado', compact('titulo'));
    
    }
}